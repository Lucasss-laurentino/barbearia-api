<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Barber;
use App\Models\Hour;

class UserController extends Controller
{
    public function createUser(Request $request) {
        
        $user = User::create([
            'email' => $request->email,
            'password' =>  Hash::make($request->password),
        ]);
    
        return $user;    
        
    }

    public function login(Request $request) {

        $credentials = ['email' => $request->email, 'password' => $request->password];

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
        $hours = Hour::all();

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

        $hours = Hour::all();
        return [$hour, $hours];
    }
}
