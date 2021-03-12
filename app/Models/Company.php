<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    protected $fillable = [
        'active',
        'name',
        'photo'
    ];
    public function areas(){
        return $this->hasMany(Area::class);
    }
    public function departments(){
        return $this->hasMany(Department::class);
    }
    public function invitations(){
        return $this->hasMany(Invitation::class);
    }
    public function requests(){
        return $this->hasMany(Request::class);
    }
    public function types(){
        return $this->hasMany(Type::class);
    }
    public function statuses(){
        return $this->hasMany(Status::class);
    }
    public function clients(){
        return $this->hasMany(Client::class);
    }
    public function users(){
        return $this->belongsToMany(User::class,'company_user')->withPivot('rol','active');
    }
}
