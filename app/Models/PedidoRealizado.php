<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class PedidoRealizado extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'pedidos_realizados';

    protected $fillable = [
        'cliente_id',
        'producto_id',
        'cantidad',
        'total',
        'estatus',
    ];

    public function cliente()
    {
        return $this->belongsTo(LoginCliente::class, 'cliente_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
