<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LateReturnFine extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrow_id',
        'fine_amount',
        'payment_date',
        'payment',
    ];

    public function borrow(){
        return $this->belongsTo(Borrow::class);
    }
}
