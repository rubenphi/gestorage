<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';
    protected $fillable = [
        'name',
        'company_id',
        'companyStatus'
    ];
    protected $hidden = [
        'companyStatus'
    ];
    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function requests(){
        return $this->hasMany(Request::class);
    }
}
