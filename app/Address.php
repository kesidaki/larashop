<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
    	'user_id',
    	'name',
        'profession',
        'doy',
        'afm',
    	'address',
    	'tk',
    	'city',
    	'state',
    	'country',
    	'phone',
    	'phone_2',
    	'email'
    ];

    public function user() 
    {
    	return $this->belongsTo(User::class);
    }
}
