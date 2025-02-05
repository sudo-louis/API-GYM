<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoRealizado extends Model
{
    use HasFactory;

    protected $table = 'pedidos_realizados';

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
        return $this->belongsTo(ProductoAlta::class, 'producto_id');
    }
}
