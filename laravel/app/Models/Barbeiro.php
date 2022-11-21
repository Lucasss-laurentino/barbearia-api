<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barbeiro extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'perfil',
    ];

    public function horarios() {
        return $this->hasMany(Horario::class);
    }
}
