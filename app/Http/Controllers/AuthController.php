<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


    public function authenticate(Request $request)
    {
        // Validate the form data
        $request->validate([
           'email' => 'required|email',
           'password' => 'required',
        ]);

        // Attempt to log in the user
        if (auth()->attempt($request->only('email', 'password'))) {
            // Authentication successful
            return redirect()->route('dashboard');
        }

        // Authentication failed
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function login()
    {
        Auth::logout();

        return view('login');
    }

    // Logout route
    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }


}
