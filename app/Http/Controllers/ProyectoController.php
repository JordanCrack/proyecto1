<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function index() {
        return Proyecto::with('tareas')->get();
    }

    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $proyecto = Proyecto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return response()->json($proyecto, 201);
    }

    public function update(Request $request, Proyecto $proyecto) {
        $proyecto->update($request->only(['nombre', 'descripcion']));
        return response()->json($proyecto, 200);
    }

    public function destroy(Proyecto $proyecto) {
        $proyecto->delete();
        return response()->json(null, 204);
    }
}