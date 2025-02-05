<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\Laravel\Facades\Schema;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return response()->json($categorias);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_categoria' => 'required|string|max:100',
        ]);

        $categoria = Categoria::create([
            'nombre_categoria' => $request->nombre_categoria,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Categoría creada con éxito', 'categoria' => $categoria], 201);
    }

    public function show($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        return response()->json($categoria);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_categoria' => 'required|string|max:100',
        ]);

        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        $categoria->update([
            'nombre_categoria' => $request->nombre_categoria,
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Categoría actualizada con éxito', 'categoria' => $categoria]);
    }

    public function destroy($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        $categoria->delete();

        return response()->json(['message' => 'Categoría eliminada con éxito']);
    }
}
