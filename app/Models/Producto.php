<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Producto extends Model
{
    protected $connection = 'mongodb';

    protected $table = 'productos';

    protected $fillable = [
        'nombre_producto',
        'descripcion',
        'proveedor',
        'categoria',
        'cantidad_en_stock',
        'precio',
        'foto',
        'created_at',
        'updated_at',
    ];

    public $timestamps = false;
}
