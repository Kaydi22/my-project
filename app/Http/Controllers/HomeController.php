<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;


class HomeController extends Controller
{
    public function __contructor()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if (auth()->check()) {
            // El usuario está autenticado, podemos obtener a quienes sigue
            $ids = auth()->user()->followings->pluck('id')->toArray();
            $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);
        } else {
            // El usuario no está autenticado, mostrar publicaciones de todos los usuarios o manejar este caso según sea necesario
            $posts = Post::paginate(20);
        }
    
        return view('home', [
            'posts' => $posts
        ]);
    }
    
}
