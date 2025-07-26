<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Http\Requests\ResetPasswordRequest;


use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userCreate(UserRequest $request): RedirectResponse
    {

        User::create([
            'name' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password)

        ]);
        return redirect()->route('login')->with('success', $request->nombre . ' User request created, wait for authorization');
    }

    public function resetPassword(ResetPasswordRequest $request): RedirectResponse
    {
        User::where('email', $request->input('email'))
            ->update([
                'password' => Hash::make($request->input('password')),
                'authorized' => false,
            ]);

        return redirect()->route('login')->with('success', 'User password has been reset, wait for authorization');
    }
}
