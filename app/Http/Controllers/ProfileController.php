<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('login');
        }

        $usuario = session('usuario');
        $rol = session('rol');

        return view('profile', compact('usuario', 'rol'));
    }
}
