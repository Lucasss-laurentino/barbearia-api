<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BarberFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Barber;
use App\Models\Hour;

class UserController extends Controller
{
    public function createUser(BarberFormRequest $request) {

        
        $user = User::create([
            'email' => $request->data['email'],
            'password' =>  Hash::make($request->data['password']),
        ]);
    
        return $user;
        
    }

    public function login(BarberFormRequest $request) {

        
        $credentials = ['email' => $request->data['email'], 'password' => $request->data['password']];

        if(Auth::attempt($credentials)) {

            $user = Auth::user();

            $token = $user->createToken('token');

            return [$user, $token->plainTextToken];
        
        } else {
        
            return 'erro';
        
        }

    }

    public function index() {

        // Retornar todos barbeiros e horarios de cada barbeiro
        
        $barbers = Barber::all();
        $hours = Hour::query()->orderBy('time')->get();

        return [$barbers, $hours];
        
    }

    public function reserve(Request $request) {

        // check if user is reserved
        $user = User::find($request->userId);

        if($user->marcado === 1){

            // unmark hour
            $hourReserved = Hour::where('user_id', $user->id)->get()->first();
            $hourReserved->reserved = 0;
            $hourReserved->user_id = null;
            $hourReserved->save();
        
        }

        // mark new hour
        $hour = Hour::find($request->hourId);
    
        $hour->reserved = 1;
        $hour->user_id = $request->userId;
        $hour->save();

        $user->marcado = 1;
        $user->save();

        $hours = Hour::query()->orderBy('time')->get();

        $barber = Barber::where('id', $hour->barber_id)->get()->first();

        // Retornando hour e barber para setar a modal de horario marcado no front
        return [$hour, $hours, $barber];
    }

    public function getHourReserved(Request $request) {
        
        $user = User::find($request->userId)->get()->first();

        if($user->marcado) {
            
            $hourReserved = Hour::where('user_id', $user->id)->get()->first();
            $barberReserved = Barber::find($hourReserved->barber_id)->get()->first();
            
            return [$hourReserved, $barberReserved];
        }

        return '';

    }

    public function unmark(Request $request) {

        $hour = Hour::where('id', $request->hourId)->get()->first();

        if($hour){
            
            $user = User::find($hour->user_id)->get()->first();
            $user->marcado = 0;
            $user->save();

            $hour->reserved = 0;
            $hour->user_id = null;
            $hour->save();

            $hours = Hour::query()->orderBy('time')->get();
            
            return $hours;

        }

    }
}
