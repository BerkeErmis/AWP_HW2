<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        // 1. XML dosyasının yolunu belirle
        $xmlPath = storage_path('app/LV2.xml');
        if (!file_exists($xmlPath)) {
            abort(404, 'LV2.xml dosyası bulunamadı!');
        }

        // 2. XML dosyasını oku
        $xml = simplexml_load_file($xmlPath);
        $people = [];
        foreach ($xml->record as $record) {
            $people[] = [
                'id' => (string)$record->id,
                'first_name' => (string)$record->ime,
                'last_name' => (string)$record->prezime,
                'email' => (string)$record->email,
                'gender' => (string)$record->spol,
                'picture' => (string)$record->slika,
                'resume' => (string)$record->zivotopis,
            ];
        }

        // 3. View'a gönder
        return view('profiles.index', ['people' => $people]);
    }
}
