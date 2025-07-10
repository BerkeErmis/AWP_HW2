<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-database {database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Veritabanını yedekler, .txt dosyasına kaydeder ve ZIP olarak arşivler.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 1. Komut parametresinden veritabanı adını al
        $databaseName = $this->argument('database');

        // 2. SQLite dosya yolunu oluştur (ör: database/database.sqlite)
        $dbPath = database_path($databaseName . '.sqlite');
        if (!file_exists($dbPath)) {
            $this->error('Veritabanı dosyası bulunamadı: ' . $dbPath);
            return 1;
        }

        // 3. Geçici olarak bu bağlantıyı kullanmak için config ayarını değiştir
        config(['database.connections.temp_sqlite' => [
            'driver' => 'sqlite',
            'database' => $dbPath,
            'prefix' => '',
        ]]);

        // 4. DB facade ile bağlantı kur
        $db = \DB::connection('temp_sqlite');

        // 5. Tüm tablo isimlerini çek
        $tables = $db->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%';");
        $tableNames = array_map(fn($t) => $t->name, $tables);

        // Test amaçlı tablo isimlerini ekrana yazdır
        $this->info('Tablolar: ' . implode(', ', $tableNames));

        // 6. Her tabloyu dolaş, verileri çek ve INSERT satırlarını oluştur
        $lines = [];
        foreach ($tableNames as $table) {
            // Kolon isimlerini al
            $columns = $db->getSchemaBuilder()->getColumnListing($table);
            // Tüm satırları al
            $rows = $db->table($table)->get();
            foreach ($rows as $row) {
                $values = [];
                foreach ($columns as $col) {
                    $val = $row->$col;
                    // NULL ise NULL yaz, değilse tek tırnak içinde yaz
                    $values[] = is_null($val) ? 'NULL' : ("'" . str_replace("'", "''", $val) . "'");
                }
                $lines[] = "INSERT INTO $table (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $values) . ");";
            }
        }

        // 7. Dosya adını oluştur
        $date = date('Ymd_His');
        $txtFile = storage_path("app/backup_{$databaseName}_{$date}.txt");

        // 8. Satırları dosyaya yaz
        file_put_contents($txtFile, implode("\n", $lines));

        $this->info('Yedek dosyası oluşturuldu: ' . $txtFile);

        // 9. ZIP dosyasını oluştur
        $zipFile = storage_path("app/backup_{$databaseName}_{$date}.zip");
        $zip = new \ZipArchive();
        if ($zip->open($zipFile, \ZipArchive::CREATE) === TRUE) {
            $zip->addFile($txtFile, basename($txtFile));
            $zip->close();
            $this->info('ZIP dosyası oluşturuldu: ' . $zipFile);
        } else {
            $this->error('ZIP dosyası oluşturulamadı!');
        }
    }
}
