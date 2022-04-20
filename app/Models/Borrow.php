<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'borrower_id',
        'issue_date',
        'due_date',
        'return_date',
        'late_return_status', // NO, PAID
    ];

    protected $appends = ['pending_payment', 'suggested_fine_amount'];

    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function borrower(){
        return $this->belongsTo(Borrower::class);
    }

    public function lateReturnFine(){
        return $this->hasOne(LateReturnFine::class);
    }

    public function getPendingPaymentAttribute(){
        return now()->gt(Carbon::parse($this->due_date)) && $this->late_return_status != 'PAID';
    }

    public function getSuggestedFineAmountAttribute(){
        return now()->diffInDays(Carbon::parse($this->due_date)) * 20;
    }

}
