<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'estado', 'proyecto_id', 'user_id'];

    public function proyecto() {
        return $this->belongsTo(Proyecto::class);
    }

    public function usuario() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
