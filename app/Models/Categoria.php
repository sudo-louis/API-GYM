<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Categoria extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'categorias';

    protected $fillable = [
        'nombre_categoria',
        'created_at',
        'updated_at',
    ];

    public $timestamps = false;
}
