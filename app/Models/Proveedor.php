<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Proveedor extends Model
{
    protected $connection = 'mongodb';

    protected $table = 'proveedores';

    protected $fillable = [
        'foto',
        'nombre_empresa',
        'nombre_contacto',
        'telefono',
        'correo',
        'productos_suministrados',
        'created_at',
        'updated_at',
    ];

    public $timestamps = false;
}
