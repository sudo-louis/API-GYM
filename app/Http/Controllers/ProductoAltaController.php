<?php

namespace App\Http\Controllers;

use App\Models\ProductoAlta;
use Illuminate\Http\Request;

class ProductoAltaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $producto = ProductoAlta::create([
            'nombre_producto' => $request->nombre_producto,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
        ]);

        return response()->json([
            'message' => 'Producto registrado exitosamente',
            'data' => $producto,
        ], 201);
    }

    public function index()
    {
        $productos = ProductoAlta::all();

        return response()->json([
            'message' => 'Productos encontrados',
            'data' => $productos,
        ], 200);
    }

    public function show($id)
    {
        $producto = ProductoAlta::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json([
            'message' => 'Producto encontrado',
            'data' => $producto,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $producto = ProductoAlta::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $request->validate([
            'nombre_producto' => 'string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'numeric|min:0',
            'stock' => 'integer|min:0',
        ]);

        $producto->nombre_producto = $request->nombre_producto ?? $producto->nombre_producto;
        $producto->descripcion = $request->descripcion ?? $producto->descripcion;
        $producto->precio = $request->precio ?? $producto->precio;
        $producto->stock = $request->stock ?? $producto->stock;

        $producto->save();

        return response()->json([
            'message' => 'Producto actualizado exitosamente',
            'data' => $producto,
        ], 200);
    }

    public function destroy($id)
    {
        $producto = ProductoAlta::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $producto->delete();

        return response()->json(['message' => 'Producto eliminado exitosamente'], 200);
    }
}
