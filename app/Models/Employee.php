<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
    use HasRoles;

    protected $fillable = [
        'employee_code', 'cin', 'cin_attachment','profile_picture', 'address', 'personal_num',
        'professional_num', 'pin', 'salary', 'is_project', 'hours', 'ice',
        'professional_email', 'cnss', 'assurance', 'user_id', 'department_id', 'status_id'
    ];

    public function leaves() { return $this->hasMany(Leave::class); }
    public function payments() { return $this->hasMany(Payment::class); }
    public function freelancerProjects() { return $this->hasMany(FreelancerProject::class); }
    public function typeEmployees() { return $this->hasMany(TypeEmployee::class); }
    public function employeeDepartments() { return $this->hasMany(EmployeeDepartment::class); }



    public function operator() { return $this->belongsTo(Operator::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function status() { return $this->belongsTo(Status::class); }
}
