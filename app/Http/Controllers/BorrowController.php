<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrower;
use App\Models\Borrow;

class BorrowController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data = Borrow::with('book','borrower')->orderBy('created_at','desc')->get();
        $books = Book::all();
        $borrowers = Borrower::all();
        return view('auth.issues', compact('data','books','borrowers'));
    }

    public function create(Request $request){
        $vr = $request->validate([
            'Book' => 'required|integer',
            'Borrower' => 'required|integer',
            'IssueDate' => 'required|date_format:Y-m-d',
            'DueDate' => 'required|date_format:Y-m-d',
        ]);

        $status = Borrow::create([
            'book_id' => $vr['Book'],
            'borrower_id' => $vr['Borrower'],
            'issue_date' => $vr['IssueDate'],
            'due_date' => $vr['DueDate'],
        ]);

        if($status){
            return response()->json(['success' => 'Entry Created']);
        }
        return response()->json(['error' => 'Entry Failed']);
    }

    public function update(Request $request){
        $vr = $request->validate([
            'id' => 'required|integer',
            'Book' => 'required|integer',
            'Borrower' => 'required|integer',
            'IssueDate' => 'required|date_format:Y-m-d',
            'DueDate' => 'required|date_format:Y-m-d',
        ]);
        $data = Borrow::find($vr['id']);
        if(! $data){
            return response()->json(['error' => 'Entry Not Found']);
        }
        $status = $data->update([
            'book_id' => $vr['Book'],
            'borrower_id' => $vr['Borrower'],
            'issue_date' => $vr['IssueDate'],
            'due_date' => $vr['DueDate'],
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
        $data = Borrow::find($vr['id']);
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
