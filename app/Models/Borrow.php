<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'borrower_id',
        'issue_date',
        'due_date',
        'return_date',
        'late_return_status',
    ];

    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function borrower(){
        return $this->belongsTo(Borrower::class);
    }

}
