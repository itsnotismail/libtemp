<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('guest', ['except' => ['logout']]);
    }

    public function login(){
        return view('login');
    }

    public function register(){
        return view('register');
    }

    public function store(){
        // Create User
        
    }
    
    public function auth(){
        $credentials = request(['username', 'password']);
        if (!auth()->attempt($credentials)) {
            return back()->withErrors([
                'message' => 'Invalid Credentials'
            ]);
        }
        return redirect()->route('home');
    }

    public function logout(){
        auth()->logout();
        return redirect()->route('login');
    }
}
