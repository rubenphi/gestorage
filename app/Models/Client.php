<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Client extends Model
{
    protected $table = 'clients';
    protected $fillable = [
        'active',
        'first_name',
        'last_name',
        'country',
        'region',
        'city',
        'document',
        'email',
        'address',
        'company_id',
        'companyDocument'

    ];

    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
}
