<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function showLoginForm(){
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        $user = User::where('email', $credentials['email'])
                   ->where('active', true)
                   ->first();

        if ($user && Hash::check($credentials['password'], $user->password_hash)) {
            Auth::login($user);
            
            return $this->redirectBasedOnRole($user->role);
        }

        return redirect()->back()
                         ->withInput($request->only('email'))
                         ->withErrors(['email' => 'El usuario o la contraseña son incorrectos']);
    }
    protected function redirectBasedOnRole($role)
    {
        return match($role) {
            'receptionist' => redirect()->route('receptionist.dashboard'),
            'groomer' => redirect()->route('groomer.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            default => redirect()->route('dashboard')
        };
    }

    public function dashboard()
    {
        $user = Auth::user();
        return $this->redirectBasedOnRole($user->role);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}