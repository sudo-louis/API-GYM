<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpleadoRequest;
use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller {
    public function index()
    {
        $datos=Empleado::all();
        return response()->json([
            "datos"=> $datos,
        ],200
    );
    }

    public function store(EmpleadoRequest $request)
    {
        $datosempleados = $request->all();
        $imagen = $request->file('foto');
        if ($imagen && $imagen->isValid()) {
            $rutaCarpeta = 'storage/uploads';
            $nombreImagen = $imagen->getClientOriginalName();
            $request->file('foto')->move($rutaCarpeta, $nombreImagen);
            $datosempleados['foto'] = $nombreImagen;
        }

        $empleado = Empleado::create($datosempleados);

        return response()->json([
            "empleado"=> $empleado,
        ],200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $empleado = Empleado::where('ID', '=', $id)->first();
        return response()->json([
            "empleado"=> $empleado,
        ],200
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleado.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        try {
            $empleado = Empleado::where('ID', '=', $id)->first();

            if (!$empleado) {
                return response()->json(['message' => 'empleado no encontrado.'], 404);
            }

            $validatedData = $request->validate([
                'foto'=> 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:2048',
                'nombre'=> 'string|max:50',
                'apellido'=> 'string|max:50',
                'fecha_contratacion'=> 'date',
                'telefono'=> 'string|max:15',
                'correo'=> 'string',
                'rol'=> 'string|max:50',
            ]);

            if ($request->foto)
                $empleado->foto = $request->foto;

            if ($request->nombre)
                $empleado->nombre = $request->nombre;

            if ($request->apellido)
                $empleado->apellido = $request->apellido;

            if ($request->fecha_contratacion)
                $empleado->fecha_contratacion = $request->fecha_contratacion;

            if ($request->telefono)
                $empleado->telefono = $request->telefono;

            if ($request->correo)
                $empleado->correo = $request->correo;

            if ($request->rol)
            $empleado->rol = $request->rol;

            
            if ($request->hasFile('foto')) {
                $imagen = $request->file('foto');
                $rutaCarpeta = 'storage/uploads';
                $nombreImagen = $imagen->getClientOriginalName();
                $request->file('foto')->move($rutaCarpeta, $nombreImagen);
                $empleado->foto = $nombreImagen;
            }

            $empleado->save();

            return response()->json(['empleado' => $empleado, 'message' => 'empleado actualizado correctamente.'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Ocurrió un error al actualizar el empleado. '.$e->getMessage(),
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Empleado::where('ID','=',$id)->delete();
        return response()->json(['message' => 'empleado borrado correctamente.'], 200);
    }
}