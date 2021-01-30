<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $fillable = [
        'active',
        'name',
        'company_id'
    ];

    public function areas()
    {
        return $this->hasMany(Area::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }

    public function fromDepartment()
    {
        return $this->hasMany(Request::class, 'from_department_id', 'id');
    }

    public function toDepartment()
    {
        return $this->hasMany(Request::class, 'to_department_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
