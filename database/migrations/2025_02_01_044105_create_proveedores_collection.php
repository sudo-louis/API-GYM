<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('mongodb')->create('proveedores', function (Blueprint $collection) {
            $collection->string('foto', 255)->nullable();
            $collection->string('nombre_empresa', 100);
            $collection->string('nombre_contacto', 50)->nullable();
            $collection->string('telefono', 15)->nullable();
            $collection->string('correo', 100)->nullable();
            $collection->text('productos_suministrados')->nullable();
            $collection->date('updated_at')->nullable();
            $collection->date('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('proveedores');
    }
};
