<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // Validación
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->attempt($request->only('email', 'password'), $request->remenber)) {
            return back()->with('mensaje', 'Credenciales Incorrectas');
        }

        // Redireccionar
        return redirect()->route('posts.index', auth()->user());
    }
}
