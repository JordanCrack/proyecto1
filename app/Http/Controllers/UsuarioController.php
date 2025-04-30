<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UsuarioController extends Controller
{
    public function index()
{
    $usuarios = User::select('id', 'name as nombre', 'email')->get();

    return response()->json($usuarios);
}

    public function register(Request $request)
    {
        // Validar los datos del registro
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:4',
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Usuario registrado correctamente'], 201);
        
    }

    public function login(Request $request)
{
    \Log::info('Intentando iniciar sesión con: ' . $request->email);

    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        \Log::error('Usuario no encontrado.');
        return response()->json(['error' => 'Credenciales incorrectas.'], 401);
    }

    if (!Hash::check($request->password, $user->password)) {
        \Log::error('Contraseña incorrecta.');
        return response()->json(['error' => 'Credenciales incorrectas.'], 401);
    }

    try {
        $token = $user->createToken('auth_token')->plainTextToken;
        \Log::info('Token generado correctamente.');

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    } catch (\Exception $e) {
        \Log::error('Error al generar el token: ' . $e->getMessage());
        return response()->json(['error' => 'Error interno del servidor.'], 500);
    }

}

    
}