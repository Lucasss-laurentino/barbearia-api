<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hour extends Model
{
    use HasFactory;

    protected $fillable = [
        'time',
        'reserved',
        'barber_id',
        'user_id',
    ];

    public function barber() {
        return $this->belongsTo(Barbeiro::class);
    }
}
