<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaccion extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'cajero');
    }

    public function account():BelongsTo{
        return $this->belongsTo(Account::class, 'cuenta_id');
    }


}
