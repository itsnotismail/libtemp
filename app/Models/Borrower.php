<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ic',
        'phone_number',
        'address',
    ];

    public function borrows(){
        return $this->hasMany(Borrow::class);
    }
}
