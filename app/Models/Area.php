<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';
    protected $fillable = [
        'active',
        'name',
        'department_id',
        'company_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class,'department_id');
    }

    public function fromArea()
    {
        return $this->hasMany(Request::class, 'from_area_id', 'id');
    }

    public function toArea()
    {
        return $this->hasMany(Request::class, 'to_area_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['rol','active']);
    }
}





