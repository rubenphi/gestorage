<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'active',
        'first_name',
        'last_name',
        'photo'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'superadmin',
        'remember_token',
        'companies'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function companies(){
        return $this->belongsToMany(Company::class,'company_user')->withPivot('id','rol','active');
    }
    public function requests(){
        return $this->hasMany(Request::class);
    }
    public function areas(){
        return $this->belongsToMany(Area::class)->withPivot('id','rol','active');
    }
    public function departments(){
        return $this->belongsToMany(Department::class)->withPivot('id','rol','active');
    }
}
