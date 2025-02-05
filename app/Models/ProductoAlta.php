<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoAlta extends Model
{
    use HasFactory;

    protected $table = 'productos_alta';

    protected $fillable = [
        'nombre_producto',
        'descripcion',
        'precio',
        'stock',
    ];

    public function pedidos()
    {
        return $this->hasMany(PedidoRealizado::class, 'producto_id');
    }
}
