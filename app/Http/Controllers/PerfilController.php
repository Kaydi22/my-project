<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Models\User;


class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
       return view('perfil.index');
    }

    public function store(Request $request)
    {
        // Modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]);
    
        // Validar el Request
        $this->validate($request, [
            'username' => ['required', 'unique:users,username,' . auth()->user()->id, 
            'min:3', 'max:20', 'not_in:twitter,editar-perfil'],
        ]);
        
    
        // Si hay una imagen
        if ($request->imagen) {
            $imagen = $request->file('imagen');
            $nombreImagen = Str::uuid() . "." . $imagen->extension();
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);
            $imagenPath=public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }
    
        // Guardar Cambios
        $usuario = User::find(auth()->user()->id);
    
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();
       
        // Redireccionar
        return redirect()->route('posts.index', $usuario->username);
    }
    
}
