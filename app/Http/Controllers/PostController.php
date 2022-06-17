<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(User $user)
    {
        $posts = Post::where('user_id', $user->id)->latest()->paginate(8);

        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // Validación
        $this->validate($request, [
            'titulo' => 'required|max:250',
            'descripcion' => 'required|max:500',
            'imagen' => 'required',
        ]);

        Post::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id,
        ]);

        // Redireccionar
        return redirect()->route('posts.index', auth()->user());
    }

    public function show(User $user, Post $post)
    {
        return view('posts.show', [
            'user' => $user,
            'post' => $post
        ]);
    }

    public function destroy(Post $post)
    {
        // Si es el creador puede eliminar
        $this->authorize('delete', $post);
        $post->delete();

        // Eliminar imagen
        $imagen_path = public_path('uploads') . $post->imagen;
        if (File::exists($imagen_path)) {
            unlink($imagen_path);
        }

        // Redireccionar
        return redirect()->route('posts.index', auth()->user());
    }
}
