<?php

namespace App;

use App\Address;
use Laravel\Passport\HasApiTokens;
use App\Transformers\UserTransformer;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    
    use Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $transformer = UserTransformer::class;
    protected $table    = 'users';
    protected $dates    = ['deleted_at'];
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'verified',
        'verification_token',
        'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
        'verification_token'
    ];

    const VERIFIED_USER   = '1';
    const UNVERIFIED_USER = '0';

    const ADMIN_USER   = 'true';
    const REGULAR_USER = 'false';

    public function isVerified() 
    {
        return $this->verified == User::VERIFIED_USER;
    }

    public function isAdmin() 
    {
        return $this->admin == User::ADMIN_USER;
    }

    public static function generateVerificationCode() 
    {
        return str_random(40);
    }

    /**
    * Mutators
    * Their syntax is:
    * "set"
    * "Name" of the attribute
    * "Attribute" word
    */
    public function setNameAttribute($name) 
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function setEmailAttribute($email) 
    {
        $this->attributes['email'] = strtolower($email);
    }

    /**
    * Accessors
    * "get"
    * "Name" of the attribute
    * "Attribute" word
    */
    public function getNameAttribute($name) 
    {
        return ucwords($name);
    }

    /**
    * Address Information Relationship (One on One)
    */
    public function address() 
    {
        return $this->hasOne(Address::class);
    }

}
