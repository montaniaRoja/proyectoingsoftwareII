<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Payment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function paymentDetails(){
        return $this->hasMany(PaymentDetail::class);
    }
}
