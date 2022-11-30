<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BarberFormRequest;
use App\Models\Barber;
use App\Models\Hour;

class AdmController extends Controller
{
    public function createBarber(BarberFormRequest $request) {

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

        $hours = Hour::query()->orderBy('time')->get();

        return $hours;

    }

    public function barberDelete($id) {
        
        $barber = Barber::where('id', $id)->get()->first();
        $barber->delete();

        $barbers = Barber::all();
        
        return $barbers;
    
    }

    public function editBarber(Request $request) {

        $path_perfil = $request->file('image')->store($request->name,'public');

        $barber = Barber::where('id', $request->id)->get()->first();

        $barber->name = $request->name;
        $barber->perfil = $path_perfil;
        $barber->save(); 
    
        $barbers = Barber::all();
            
        return [$barber, $barbers];
    
    }

    public function deleteHour($id) {

        $hour = Hour::where('id', $id)->get()->first();

        $hour->delete();

        $hour = Hour::query()->orderBy('time')->get();

        return $hour;
    }
}
