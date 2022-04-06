<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data = Book::all();
        return view('auth.books', compact('data'));
    }

    public function create(Request $request){
        $vr = $request->validate([
            'ISBN' => 'required|string',
            'Year' => 'required|date_format:Y',
            'Title' => 'required|string',
            'Author' => 'required|string',
            'PublisherName' => 'required|string',
            'Category' => 'required|string',
        ]);

        $status = Book::create([
            'isbn' => $vr['ISBN'],
            'year_of_publication' => $vr['Year'],
            'title' => $vr['Title'],
            'author' => $vr['Author'],
            'publisher_name' => $vr['PublisherName'],
            'category' => $vr['Category'],
        ]);

        if($status){
            return response()->json(['success' => 'Entry Created']);
        }
        return response()->json(['error' => 'Entry Failed']);
    }

    public function update(Request $request){
        $vr = $request->validate([
            'id' => 'required|integer',
            'ISBN' => 'required|string',
            'Year' => 'required|date_format:Y',
            'Title' => 'required|string',
            'Author' => 'required|string',
            'PublisherName' => 'required|string',
            'Category' => 'required|string',
        ]);
        $data = Book::find($vr['id']);
        if(! $data){
            return response()->json(['error' => 'Entry Not Found']);
        }
        $status = $data->update([
            'isbn' => $vr['ISBN'],
            'year_of_publication' => $vr['Year'],
            'title' => $vr['Title'],
            'author' => $vr['Author'],
            'publisher_name' => $vr['PublisherName'],
            'category' => $vr['Category'],
        ]);

        if($status){
            return response()->json(['success' => 'Entry Updated']);
        }
        return response()->json(['error' => 'Entry Update Failed']);
    }

    public function delete(Request $request){
        $vr = $request->validate([
            'id' => 'required|integer',
        ]);
        $data = Book::find($vr['id']);
        if(! $data){
            return response()->json(['error' => 'Entry Not Found']);
        }
        $status = $data->delete();
        if($status){
            return response()->json(['success' => 'Entry Deleted']);
        }
        return response()->json(['error' => 'Entry Delete Failed']);
    }
}
