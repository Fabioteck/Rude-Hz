<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class RudeBackup extends Command
{
    protected $signature = 'rude:backup {--type=daily : Type of backup (daily or weekly)}';
    protected $description = 'Crea un backup atomico del database SQLite e un export JSON delle tabelle principali (mantenendo gli ultimi 14 backup).';

    public function handle()
    {
        $type = $this->option('type') === 'weekly' ? 'weekly' : 'daily';
        $timestamp = Carbon::now()->format('Ymd_His');
        $backupDir = database_path('backups');

        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0775, true);
        }

        // 1. Copia atomica del database SQLite
        $sqliteSource = database_path('database.sqlite');
        if (File::exists($sqliteSource)) {
            $sqliteDest = "{$backupDir}/backup_{$type}_{$timestamp}.sqlite";
            File::copy($sqliteSource, $sqliteDest);
            $this->info("Database SQLite copiato in: {$sqliteDest}");
        } else {
            $this->warn("File database.sqlite non trovato.");
        }

        // 2. Export JSON delle tabelle
        $tables = ['users', 'artists', 'tracks', 'playlists'];
        if ($type === 'weekly') {
            $tables = array_merge($tables, ['news', 'contests']);
        }

        $exportData = [];
        foreach ($tables as $table) {
            if (Schema::hasTable($table) || DB::getSchemaBuilder()->hasTable($table)) {
                $exportData[$table] = DB::table($table)->get();
            }
        }

        $jsonDest = "{$backupDir}/export_{$type}_{$timestamp}.json";
        File::put($jsonDest, json_encode($exportData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $this->info("Export JSON delle tabelle salvato in: {$jsonDest}");

        // 3. Mantenere solo gli ultimi 14 backup (sia sqlite che json)
        $this->cleanupOldBackups($backupDir, 14);

        $this->info("Backup {$type} completato con successo!");
        return 0;
    }

    private function cleanupOldBackups($dir, $keepCount = 14)
    {
        $files = File::files($dir);
        
        foreach (['sqlite', 'json'] as $ext) {
            $extFiles = array_filter($files, function ($file) use ($ext) {
                return $file->getExtension() === $ext;
            });

            usort($extFiles, function ($a, $b) {
                return $b->getMtime() <=> $a->getMtime();
            });

            if (count($extFiles) > $keepCount) {
                $toDelete = array_slice($extFiles, $keepCount);
                foreach ($toDelete as $file) {
                    File::delete($file->getPathname());
                    $this->line("Rimosso vecchio backup: " . $file->getFilename());
                }
            }
        }
    }
}
