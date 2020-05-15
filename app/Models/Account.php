<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'user_id', 'balance', 'credit', 'credit_detail_id',
    ];

    public function user()
	{
		return $this->belongsTo(User::class);
    }
}
