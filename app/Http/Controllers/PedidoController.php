<?php

namespace App\Http\Controllers;

use App\Models\PedidoRealizado;
use App\Models\Producto;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes_login,_id',
            'producto_id' => 'required|exists:productos,_id',
            'cantidad' => 'required|integer|min:1',
        ], [
            'cliente_id.exists' => 'El cliente no existe en la base de datos.',
            'producto_id.exists' => 'El producto no existe en la base de datos.',
            'cantidad.min' => 'La cantidad debe ser al menos 1.',
        ]);

        $producto = Producto::find($request->producto_id);

        if (!$producto || $producto->cantidad_en_stock < $request->cantidad) {
            return response()->json(['message' => 'Producto no disponible en la cantidad requerida'], 400);
        }

        $total = $producto->precio * $request->cantidad;

        $pedido = PedidoRealizado::create([
            'cliente_id' => $request->cliente_id,
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'total' => $total,
        ]);

        $producto->cantidad_en_stock -= $request->cantidad;
        $producto->save();

        return response()->json(['message' => 'Pedido creado exitosamente', 'data' => $pedido], 201);
    }

    public function listByClient($cliente_id)
    {
        $pedidos = PedidoRealizado::where('cliente_id', $cliente_id)->get();

        if ($pedidos->isEmpty()) {
            return response()->json(['message' => 'No se encontraron pedidos para este cliente'], 404);
        }

        return response()->json(['data' => $pedidos], 200);
    }

    public function show($id)
    {
        $pedido = PedidoRealizado::find($id);

        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        return response()->json(['data' => $pedido], 200);
    }

    public function cancel($id)
    {
        $pedido = PedidoRealizado::find($id);

        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        if ($pedido->estatus === 'cancelado') {
            return response()->json(['message' => 'El pedido ya está cancelado'], 400);
        }

        $producto = Producto::find($pedido->producto_id);
        $producto->cantidad_en_stock += $pedido->cantidad;
        $producto->save();

        $pedido->estatus = 'cancelado';
        $pedido->save();

        return response()->json(['message' => 'Pedido cancelado exitosamente', 'data' => $pedido], 200);
    }
}
