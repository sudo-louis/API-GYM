<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorRequest;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller {

    public function index()
    {
        $datos = Proveedor::all();
        return response()->json([
            "datos" => $datos,
        ], 200);
    }

    public function store(ProveedorRequest $request)
    {
        $datosproveedors = $request->all();
        $imagen = $request->file('foto');

        if ($imagen && $imagen->isValid()) {
            $rutaCarpeta = 'storage/uploads';
            $nombreImagen = $imagen->getClientOriginalName();
            $request->file('foto')->move($rutaCarpeta, $nombreImagen);
            $datosproveedors['foto'] = $nombreImagen;
        }

        $proveedor = Proveedor::create($datosproveedors);

        return response()->json([
            "proveedor" => $proveedor,
        ], 200);
    }

    public function show($id)
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return response()->json(['message' => 'Proveedor no encontrado.'], 404);
        }

        return response()->json([
            "proveedor" => $proveedor,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $proveedor = Proveedor::find($id);

            if (!$proveedor) {
                return response()->json(['message' => 'Proveedor no encontrado.'], 404);
            }

            $validatedData = $request->validate([
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:2048',
                'nombre_empresa' => 'string|max:100',
                'nombre_contacto' => 'string|max:50',
                'telefono' => 'string|max:15',
                'correo' => 'string|max:100',
                'productos_suministrados' => 'string',
            ]);

            if ($request->hasFile('foto')) {
                $imagen = $request->file('foto');
                $rutaCarpeta = 'storage/uploads';
                $nombreImagen = $imagen->getClientOriginalName();
                $request->file('foto')->move($rutaCarpeta, $nombreImagen);
                $proveedor->foto = $nombreImagen;
            }

            $proveedor->update($request->except(['foto']));

            return response()->json(['proveedor' => $proveedor, 'message' => 'Proveedor actualizado correctamente.'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Ocurrió un error al actualizar el proveedor. ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return response()->json(['message' => 'Proveedor no encontrado.'], 404);
        }

        $proveedor->delete();

        return response()->json(['message' => 'Proveedor borrado correctamente.'], 200);
    }
}
