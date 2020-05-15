<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    protected $fillable = [
        'user_id', 'amount', 'email', 'phone', 'reference', 'trans'
    ];

    public function user()
	{
		return $this->belongsTo(User::class);
    }
}
