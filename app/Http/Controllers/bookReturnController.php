<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;

class BookReturnController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data = Borrow::where('due_date','>=', date('Y-m-d'))->orderBy('created_at','desc')->get();
        return view('auth.bookReturns', compact('data'));
    }

    public function update(Request $request){
        $vr = $request->validate([
            'Borrow' => 'required|integer',
            'ReturnDate' => 'required|date_format:Y-m-d',
        ]);
        $data = Borrow::find($vr['Borrow']);
        if(! $data){
            return response()->json(['error' => 'Entry Not Found']);
        }
        $status = $data->update([
            'return_date' => $vr['ReturnDate'],
        ]);

        if($status){
            return response()->json(['success' => 'Entry Updated']);
        }
        return response()->json(['error' => 'Entry Failed']);
    }
}
