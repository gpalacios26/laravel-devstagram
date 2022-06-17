<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comentario;

class ComentarioController extends Controller
{
    public function store(Request $request, User $user, Post $post)
    {
        // Validación
        $this->validate($request, [
            'comentario' => 'required|max:250',
        ]);

        Comentario::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comentario' => $request->comentario,
        ]);

        // Redireccionar
        return back()->with('mensaje', 'Comentario realizado correctamente');
    }
}
