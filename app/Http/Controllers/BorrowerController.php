<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrower;

class BorrowerController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data = Borrower::all();
        return view('auth.borrowers', compact('data'));
    }

    public function create(Request $request){
        $vr = $request->validate([
            'Name' => 'required|string',
            'IC' => 'required|string',
            'PhoneNumber' => 'required|string',
            'Address' => 'required|string',
        ]);

        $status = Borrower::create([
            'name' => $vr['Name'],
            'ic' => $vr['IC'],
            'phone_number' => $vr['PhoneNumber'],
            'address' => $vr['Address'],
        ]);

        if($status){
            return response()->json(['success' => 'Entry Created']);
        }
        return response()->json(['error' => 'Entry Failed']);
    }

    public function update(Request $request){
        $vr = $request->validate([
            'id' => 'required|integer',
            'Name' => 'required|string',
            'IC' => 'required|string',
            'PhoneNumber' => 'required|string',
            'Address' => 'required|string',
        ]);
        $data = Borrower::find($vr['id']);
        if(! $data){
            return response()->json(['error' => 'Entry Not Found']);
        }
        $status = $data->update([
            'name' => $vr['Name'],
            'ic' => $vr['IC'],
            'phone_number' => $vr['PhoneNumber'],
            'address' => $vr['Address'],
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
        $data = Borrower::find($vr['id']);
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
