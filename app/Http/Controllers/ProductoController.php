<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return response()->json([
            "datos" => $productos,
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre_producto' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'proveedor' => 'nullable|exists:proveedores,_id',
            'categoria' => 'nullable|exists:categorias,_id',
            'cantidad_en_stock' => 'nullable|numeric',
            'precio' => 'nullable|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:2048',
        ]);

        $imagen = $request->file('foto');
        if ($imagen && $imagen->isValid()) {
            $rutaCarpeta = 'storage/uploads';
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->move($rutaCarpeta, $nombreImagen);
            $validatedData['foto'] = $nombreImagen;
        }

        $producto = Producto::create($validatedData);

        return response()->json([
            "producto" => $producto,
        ], 201);
    }

    public function show($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado.'], 404);
        }

        return response()->json([
            "producto" => $producto,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado.'], 404);
        }

        $validatedData = $request->validate([
            'nombre_producto' => 'sometimes|string|max:100',
            'descripcion' => 'sometimes|string|max:255',
            'proveedor' => 'sometimes|exists:proveedores,_id',
            'categoria' => 'sometimes|exists:categorias,_id',
            'cantidad_en_stock' => 'sometimes|numeric',
            'precio' => 'sometimes|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $imagen = $request->file('foto');
            $rutaCarpeta = 'storage/uploads';
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->move($rutaCarpeta, $nombreImagen);
            $producto->foto = $nombreImagen;
        }

        $producto->fill($validatedData);
        $producto->save();

        return response()->json(['producto' => $producto, 'message' => 'Producto actualizado correctamente.'], 200);
    }

    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado.'], 404);
        }

        $producto->delete();

        return response()->json(['message' => 'Producto borrado correctamente.'], 200);
    }
}
