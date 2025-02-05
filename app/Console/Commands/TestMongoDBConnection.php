<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestMongoDBConnection extends Command
{
    protected $signature = 'test:mongodb';
    protected $description = 'Probar la conexión a MongoDB';

    public function handle()
    {
        try {
            DB::connection('mongodb')->getMongoClient()->listDatabases();
            $this->info('Conexión a MongoDB exitosa.');
        } catch (\Exception $e) {
            $this->error('Error al conectar a MongoDB: ' . $e->getMessage());
        }
    }
}
