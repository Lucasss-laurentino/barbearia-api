<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
        

        return 'voce esta no index';
    }
}
