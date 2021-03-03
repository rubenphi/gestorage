<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'types';
    protected $fillable = [
        'active',
        'name',
        'time',
        'company_id'
    ];
    protected $hidden = [
        'companyType'
    ];
    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
    public function requests(){
        return $this->hasMany(Request::class);
    }
}
