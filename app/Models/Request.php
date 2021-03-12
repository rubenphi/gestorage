<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';
    protected $fillable = [
        'name',
        'created_at',
        'expire',
        'active',
        'comments',
        'code',
        'file',
        'response_address',
        'response_name',
        'response_email',
        'response_document',
        'response_type',
        'status_id',
        'company_id',
        'from_area_id',
        'from_department_id',
        'to_area_id',
        'to_department_id',
        'type_id',
        'user_id'


    ];

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class,'status_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class,'type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function toArea()
    {
        return $this->belongsTo(Area::class, 'to_area_id', 'id');
    }

    public function fromArea()
    {
        return $this->belongsTo(Area::class, 'from_area_id', 'id');
    }

    public function fromDepartment()
    {
        return $this->belongsTo(Department::class, 'from_department_id', 'id');
    }

    public function toDepartment()
    {
        return $this->belongsTo(Department::class, 'to_department_id', 'id');
    }
}
