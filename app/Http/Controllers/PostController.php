<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
    }

    public function index(User $user)
    {
        $posts = Post::where('user_id', $user->id)->latest()->paginate(20);

        return view('dashboard', [
            'user' => $user,
            'posts'=> $posts
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
         ]);
 
        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function show($username, $postId)
    {
       $user = User::where('username',$username)->firstOrFail();

       $post = Post::where('id', $postId)->where('user_id', $user->id)->first();

       if (!$post)
       {
        return redirect()->route('home');
       }
       return view('posts.show', compact('post','user'));
    }

    public function destroy(Post $post)
{
    $this->authorize('delete', $post);

    // Eliminar los comentarios asociados al post
    $post->comentarios()->delete();

    // Eliminar el post
    $post->delete();

    // Eliminar imagen
    $imagen_path = public_path('uploads/' . $post->imagen);
    if(File::exists($imagen_path)) {
        unlink($imagen_path);
        File::delete($imagen_path);
    }

    return redirect()->route('posts.index', auth()->user()->username);
}

}
