@extends('layouts.app')

@section('titulo')
    Iniciar session
@endsection

@section('contenido')
    <div class="md:flex md:justify-center md:gap-10 md:items-center">
        <div class="md:w-2/12 p-5">
            <img src="{{ asset('img/usuario.svg') }}" alt="Imagen registro de usuarios">
        </div>
        <div class="md:w-4/12 bg-white p-6 rounded-lg shadow-lg">
            <form method="POST" action="{{route('login')}}" novalidate>
                @csrf
                @if (session('mensaje'))
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{session('mensaje')}}
                    </p>
                @endif
                <div>
                    <label for=""  id="email" class="md-2 block uppercase text-gray-500 font-bold">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="Tu email"
                    class="border p-3 w-full rounded-lg" value="{{old('email')}}">
                    @error('email')
                        <p class="bg-red-500 text-while my-2 rounded-lg text-5m p-2 text-center">{{$message}}</p>
                    @enderror
                </div>
                <div>
                    <label for="" id="password" class="md-2 block uppercase text-gray-500 font-bold">Password</label>
                    <input type="password" id="password" name="password" placeholder="Tu contraseña"
                    class="border p-3 w-full rounded-lg" value="{{old('password')}}">
                    
                    @error('password')
                        <p class="bg-red-500 text-while my-2 rounded-lg text-5m p-2 text-center">{{$message}}</p>
                    @enderror
                </div>
                <div>
                    <input type="checkbox" name="remember"><label class="text-gray-500 text-sm">Mantener mi sesion abierta</label>
                </div>
                <br>
                <input type="submit" value="Iniciar sesion" class="bg-sky-600 hover:bg-sky-700 transitions-colors cursor-pointer uppercase
                font-bold w-full p-4 mt-2 text-white rounded-lg">
            </form>
        </div>
    </div>
@endsection
