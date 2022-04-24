<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use Carbon\Carbon;

class BookReturnController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data = Borrow::with('book','borrower')->whereNull('return_date')->orderBy('borrower_id')->orderBy('due_date')->get();
        return view('auth.bookReturns', compact('data'));
    }

    public function update(Request $request){
        $vr = $request->validate([
            'id' => 'required|integer',
        ]);
        $data = Borrow::find($vr['id']);
        if(! $data){
            return response()->json(['error' => 'Entry Not Found']);
        }
        if($data->return_date){
            return response()->json(['error' => 'Book already returned']);
        }
        if(now()->gt(Carbon::parse($data->due_date)) && $data->late_return_status != 'PAID'){
            return response()->json(['error' => 'Late Return Pending']);
        }
        $status = $data->update([
            'return_date' => now()->format('Y-m-d'),
        ]);

        if($status){
            return response()->json(['success' => 'Entry Updated']);
        }
        return response()->json(['error' => 'Entry Failed']);
    }
}
