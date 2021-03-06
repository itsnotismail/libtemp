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
        'payment_type',
        'payment_date',
    ];

    public function borrow(){
        return $this->belongsTo(Borrow::class);
    }
}
