<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdmController extends Controller
{
    public function createBarber(Request $request) {
        return $request->all();
    }
}
