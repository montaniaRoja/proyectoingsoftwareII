<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function loginUser(LoginRequest $request)
    {
        // Buscar el usuario por email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('danger', 'User not found.');
        }

        // Verificar si el usuario está autorizado
        if (!$user->authorized) {
            return back()->with('danger', 'Your account is not authorized.');
        }

        // Verificar la contraseña
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return back()->with('danger', 'Invalid credentials.');
        }

        $user->save();

        return redirect()->route('index')->with('success', 'Login successful!');
    }

    public function logOut(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Your Session has been finished');
    }
}
