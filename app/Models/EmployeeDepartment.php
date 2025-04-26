<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDepartment extends Model
{
    protected $fillable = ['employee_id', 'department_id'];

    public function employee() { return $this->belongsTo(Employee::class); }

    public function Department() { return $this->belongsTo(Department::class); }

}
