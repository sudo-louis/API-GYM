<?php

namespace App\Http\Controllers;

use App\Models\LoginCliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteInfoController extends Controller
{
    public function viewProfile($id)
    {
        $cliente = LoginCliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        return response()->json([
            'message' => 'Perfil encontrado',
            'data' => $cliente
        ], 200);
    }

    public function updateProfile(Request $request, $id)
    {
        $cliente = LoginCliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:clientes_login,email,' . $id,
            'password' => 'string|min:8',
        ]);

        $cliente->name = $request->name ?? $cliente->name;
        $cliente->email = $request->email ?? $cliente->email;

        if ($request->password) {
            $cliente->password = Hash::make($request->password);
        }

        $cliente->save();

        return response()->json([
            'message' => 'Perfil actualizado exitosamente',
            'data' => $cliente
        ], 200);
    }
}
