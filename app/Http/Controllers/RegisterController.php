<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //
   public function index(){
        return view('auth.register');
    }
    public function store(Request $request){

        //Modificar el Request
        $request->request->add(['username'=>Str::slug($request->username)]);
    
        $this->validate($request, [
            'name' => 'required|min:5',
            'username' => 'required|unique:users|min:3|max:30',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6',
        ]);
    
        // Hash the password
        $hashedPassword = bcrypt($request->password);
    
        // Create a new user with the hashed password
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $hashedPassword, // Store the hashed password
        ]);
    
        // Attempt to authenticate the user
        auth()->attempt($request->only('email', 'password'));
    
        return redirect()->route('posts.index', ['user' => auth()->user()->username]);
    }
    
}