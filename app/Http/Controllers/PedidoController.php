<?php

namespace App\Http\Controllers;

use App\Models\PedidoRealizado;
use App\Models\ProductoAlta;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes_login,id',
            'producto_id' => 'required|exists:productos_alta,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = ProductoAlta::find($request->producto_id);

        if (!$producto || $producto->stock < $request->cantidad) {
            return response()->json(['message' => 'Producto no disponible en la cantidad requerida'], 400);
        }

        $total = $producto->precio * $request->cantidad;

        $pedido = PedidoRealizado::create([
            'cliente_id' => $request->cliente_id,
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'total' => $total,
        ]);

        $producto->stock -= $request->cantidad;
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

        $producto = ProductoAlta::find($pedido->producto_id);
        $producto->stock += $pedido->cantidad;
        $producto->save();

        $pedido->estatus = 'cancelado';
        $pedido->save();

        return response()->json(['message' => 'Pedido cancelado exitosamente', 'data' => $pedido], 200);
    }
}
