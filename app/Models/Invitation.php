<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $table = 'invitations';
    protected $fillable = [
        'code',
        'company_id'
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }
}
