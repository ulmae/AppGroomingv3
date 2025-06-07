<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Mostrar el formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar el login
     */
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intentar autenticar al usuario
        $credentials = $request->only('email', 'password');
        
        // Buscar usuario por email y verificar contraseña
        $user = User::where('email', $credentials['email'])
                   ->where('active', true)
                   ->first();

        if ($user && Hash::check($credentials['password'], $user->password_hash)) {
            // Autenticar al usuario
            Auth::login($user);
            
            // Redirigir al dashboard
            return redirect()->route('dashboard');
        }

        // Si falla la autenticación, regresar con error
        return redirect()->back()
                         ->withInput($request->only('email'))
                         ->withErrors(['email' => 'El usuario o la contraseña son incorrectos']);
    }

    /**
     * Mostrar el dashboard
     */
    public function dashboard()
    {
        return view('dashboard');
    }

    /**
     * Cerrar sesión
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}