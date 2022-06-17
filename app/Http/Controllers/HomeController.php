<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Obtener a quienes seguimos
        if (auth()->user()) {
            $ids = auth()->user()->followings->pluck('id')->toArray();
            $posts = Post::whereIn('user_id', $ids)->latest()->paginate(8);
        } else {
            $posts = Post::latest()->paginate(8);
        }

        return view('principal', [
            'posts' => $posts
        ]);
    }
}
