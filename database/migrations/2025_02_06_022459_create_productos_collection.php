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
        Schema::connection('mongodb')->create('productos', function (Blueprint $collection) {
            $collection->string('nombre_producto', 100);
            $collection->string('descripcion', 255)->nullable();
            $collection->integer('proveedor')->nullable(); // Referencia al ID del proveedor
            $collection->integer('categoria')->nullable(); // Referencia al ID de la categoria
            $collection->integer('cantidad_en_stock')->nullable();
            $collection->decimal('precio', 10, 2)->nullable();
            $collection->string('foto', 255)->nullable();
            $collection->timestamp('updated_at')->nullable();
            $collection->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('productos');
    }
};
