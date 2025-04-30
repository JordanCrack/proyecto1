<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index()
    {
        return Tarea::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'estado' => 'required|in:Pendiente,En progreso,Completada',
            'proyecto_id' => 'required|exists:proyectos,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $tarea = Tarea::create($request->only(['nombre', 'estado', 'proyecto_id', 'user_id']));

        return response()->json(['proyecto_id' => $tarea->proyecto_id], 201);
    }

    public function update(Request $request, $id)
    {
        $tarea = Tarea::findOrFail($id);

        $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'estado' => 'sometimes|required|in:Pendiente,En progreso,Completada',
            'proyecto_id' => 'sometimes|required|exists:proyectos,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $tarea->update($request->only(['nombre', 'estado', 'proyecto_id', 'user_id']));

        return response()->json(['message' => 'Tarea actualizada correctamente']);
    }

    public function destroy($id)
    {
        $tarea = Tarea::findOrFail($id);
        $tarea->delete();

        return response()->json(['message' => 'Tarea eliminada correctamente']);
    }
}
