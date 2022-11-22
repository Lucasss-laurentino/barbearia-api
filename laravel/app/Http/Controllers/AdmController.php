<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barber;
use App\Models\Hour;

class AdmController extends Controller
{
    public function createBarber(Request $request) {

        $image = $request->file('image')->store($request->name, 'public');

        $barber = Barber::create([
            'name' => $request->name,
            'perfil' => $image,
        ]);

        $barbers = Barber::all();

        return [$barber, $barbers];
    }

    public function createHour(Request $request) {

        $hour = Hour::create([
            'time' => $request->time,
            'reserved' => false,
            'barber_id' => $request->barberId,
            'user_id' => null,
        ]);

        $hours = Hour::all();

        return $hours;

    }
}
