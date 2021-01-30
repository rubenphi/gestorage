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
        'document'

    ];

    public function companies(){
        return $this->belongsToMany(Client::class,'client_company') ->withPivot('address','email');

    }
}
