<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    protected $guarded=[];

    public function customer():BelongsTo{
        return $this->belongsTo(Customer::class, 'id_cliente');
    }

}
