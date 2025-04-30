<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index() {
        return Tarea::all();
    }

    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'estado' => 'required|in:Pendiente,En progreso,Completada',
            'proyecto_id' => 'required|exists:proyectos,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $tarea = Tarea::create($request->all());
        return response()->json($tarea, 201);
    }
}