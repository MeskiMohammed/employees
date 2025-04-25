<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'employee_code', 'cin', 'profile_picture', 'address', 'personal_num',
        'professional_num', 'pin', 'salary', 'is_project', 'hours', 'ice',
        'professional_email', 'cnss', 'assurance', 'user_id', 'department_id', 'status_id'
    ];

    public function department() { return $this->belongsTo(Department::class); }
    public function status() { return $this->belongsTo(Status::class); }
    public function leaves() { return $this->hasMany(Leave::class); }
    public function evaluations() { return $this->hasMany(Evaluation::class); }
    public function payments() { return $this->hasMany(Payment::class); }
    public function freelancerProjects() { return $this->hasMany(FreelancerProject::class); }
    public function posts() { return $this->hasMany(PostEmployee::class); }
    public function operator() { return $this->belongsTo(Operator::class); }
    public function user() { return $this->belongsTo(User::class); }
}
