<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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

    public function store(Request $request){
        $vr = $request->validate([
            // 'id' => 'required|integer',
            'Name' => 'required|string',
            'StaffID' => 'required|string',
            'PhoneNumber' => 'required|string',
            'Username' => 'required|string',
            'Password' => 'nullable|string|confirmed',
        ]);
        $data = User::where('staff_id', $vr['StaffID'])->first();
        if($data){
            return response()->json(['error' => 'Staff Already Exists']);
        }
        $status = User::create([
            'name' => $vr['Name'],
            'staff_id' => $vr['StaffID'],
            'phone_number' => $vr['PhoneNumber'],
            'username' => $vr['Username'],
            'password' => @$vr['Password'] ? bcrypt($vr['Password']) : $data->password,
        ]);

        if($status){
            return redirect()->route('login');
        }
        return response()->json(['error' => 'Entry Failed']);
        
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
