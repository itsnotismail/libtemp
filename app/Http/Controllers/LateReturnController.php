<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use Carbon\Carbon;
use DB;

class LateReturnController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data = Borrow::with('book','borrower','lateReturnFine')->whereNull('return_date')->where('due_date','<',now()->format('Y-m-d'))->orderBy('borrower_id')->orderBy('due_date')->get();
        return view('auth.lateReturns', compact('data'));
    }

    public function update(Request $request){
        $vr = $request->validate([
            'id' => 'required|integer',
            'PaymentType' => 'required|string', // Cash, Card, Transfer
        ]);
        $data = Borrow::find($vr['id']);
        if(! $data){
            return response()->json(['error' => 'Entry Not Found']);
        }
        if(now()->lte(Carbon::parse($data->due_date))){
            return response()->json(['error' => 'Book is not overdue']);
        } elseif($data->late_return_status == 'PAID'){
            return response()->json(['error' => 'Late Return already paid']);
        }

        DB::beginTransaction();

        $data->lateReturnFine()->updateOrCreate([
            'fine_amount' => $data->suggested_fine_amount,
            'payment_type' => $vr['PaymentType'],
            'payment_date' => now()->format('Y-m-d'),
        ]);
        $status = $data->update(['late_return_status' => 'PAID']);

        DB::commit();

        if($status){
            return response()->json(['success' => 'Late Return Paid']);
        }
        return response()->json(['error' => 'Entry Failed']);
    }
}
