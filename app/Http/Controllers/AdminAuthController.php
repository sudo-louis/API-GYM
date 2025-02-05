<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Validator;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('admin')->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json([
            'message' => 'Hi ' . auth('admin')->user()->name,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => auth('admin')->user(),
        ], 200);
    }

    public function logout()
    {
        auth('admin')->logout();

        return response()->json([
            'message' => 'You have successfully logged out'
        ], 200);
    }

    public function refresh()
    {
        $token = auth('admin')->refresh();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }
}
