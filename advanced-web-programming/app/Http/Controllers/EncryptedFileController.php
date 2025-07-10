<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EncryptedFileController extends Controller
{
    // Yükleme formunu göster
    public function showUploadForm()
    {
        return view('encrypted_files.upload');
    }

    // Dosya yükleme ve şifreleme işlemi
    public function upload(Request $request)
    {
        // 1. Dosya doğrulama
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpeg,png|max:5120', // 5MB max
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $content = file_get_contents($file->getRealPath());

        // 2. Mcrypt ile şifreleme (AES-256-CBC)
        $key = 'my_secret_key_12345'; // Gerçek uygulamada .env'den alınmalı
        $iv = random_bytes(16); // 16 byte IV
        $encrypted = openssl_encrypt($content, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        $dataToSave = base64_encode($iv . $encrypted); // IV + şifreli veri

        // 3. Şifreli dosyayı kaydet
        $encFileName = uniqid('enc_') . '_' . $originalName . '.enc';
        $encFilePath = storage_path('app/encrypted/' . $encFileName);
        if (!is_dir(storage_path('app/encrypted'))) {
            mkdir(storage_path('app/encrypted'), 0777, true);
        }
        file_put_contents($encFilePath, $dataToSave);

        return redirect()->back()->with('success', 'Dosya şifrelenip yüklendi!');
    }

    // Şifreli dosyaları listele
    public function list()
    {
        $dir = storage_path('app/encrypted');
        $files = [];
        if (is_dir($dir)) {
            foreach (scandir($dir) as $file) {
                if ($file !== '.' && $file !== '..') {
                    $files[] = $file;
                }
            }
        }
        return view('encrypted_files.list', ['files' => $files]);
    }

    // Şifreli dosyayı çöz ve indir
    public function download($filename)
    {
        $filePath = storage_path('app/encrypted/' . $filename);
        if (!file_exists($filePath)) {
            abort(404, 'Dosya bulunamadı!');
        }
        $data = base64_decode(file_get_contents($filePath));
        $iv = substr($data, 0, 16); // İlk 16 byte IV
        $encrypted = substr($data, 16);
        $key = 'my_secret_key_12345'; // Aynı anahtar
        $decrypted = openssl_decrypt($encrypted, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        // Orijinal dosya adını bulmak için '_' ile ayırıp ilk '_' sonrası kısmı al
        $parts = explode('_', $filename, 2);
        $originalName = isset($parts[1]) ? preg_replace('/\.enc$/', '', $parts[1]) : 'indirilen_dosya';
        return response($decrypted)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', 'attachment; filename="' . $originalName . '"');
    }
}
