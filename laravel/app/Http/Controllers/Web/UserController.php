<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    // Muestra el formulario de login
    public function showLoginForm()
    {
        return view('user.login');
    }

    // Maneja la acción de login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Autenticación exitosa
            return redirect('/')/*->intended('dashboard')*/;
        }

        // Autenticación fallida
        return redirect()->back()->with('error', 'Credenciales inválidas');
    }

    // Muestra el formulario de registro
    public function showRegisterForm()
    {
        return view('user.register');
    }

    // Maneja la acción de registro
    public function register(Request $request)
    {
        // Aquí debes agregar la lógica para registrar al usuario
        // Por ejemplo, validar los datos y crear el usuario en la base de datos

        return redirect()->route('login')->with('success', 'Registro exitoso');
    }

    // Maneja la acción de logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
