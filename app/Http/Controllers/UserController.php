<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data = User::all();
        return view('auth.users', compact('data'));
    }

    public function update(Request $request){
        $vr = $request->validate([
            'id' => 'required|integer',
            'Name' => 'required|string',
            'StaffID' => 'required|string',
            'PhoneNumber' => 'required|string',
            'Username' => 'required|string',
            'Password' => 'nullable|string',
        ]);
        $data = User::find($vr['id']);
        if(! $data){
            return response()->json(['error' => 'Entry Not Found']);
        }
        $status = $data->update([
            'name' => $vr['Name'],
            'staff_id' => $vr['StaffID'],
            'phone_number' => $vr['PhoneNumber'],
            'username' => $vr['Username'],
            'password' => @$vr['Password'] ? bcrypt($vr['Password']) : $data->password,
        ]);

        if($status){
            return response()->json(['success' => 'Entry Updated']);
        }
        return response()->json(['error' => 'Entry Failed']);
    }
    
    public function delete(Request $request){
        $vr = $request->validate([
            'id' => 'required|integer',
        ]);
        $data = User::find($vr['id']);
        if(! $data){
            return response()->json(['error' => 'Entry Not Found']);
        }
        $status = $data->delete();

        if($status){
            return response()->json(['success' => 'Entry Deleted']);
        }
        return response()->json(['error' => 'Entry Failed']);
    }
}
