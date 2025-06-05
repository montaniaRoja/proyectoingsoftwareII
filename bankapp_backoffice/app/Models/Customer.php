<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $guarded=[];

    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function accounts():HasMany{
        return $this->hasMany(Account::class, 'id_cliente');
    }
}
