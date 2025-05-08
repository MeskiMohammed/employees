<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use LogsActivity;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->logCreation($model);
        });

        static::updated(function ($model) {
            $model->logUpdate($model);
        });

        static::deleted(function ($model) {
            $model->logDeletion($model);
        });
    }

    protected $fillable = [
        'employee_code', 'cin', 'cin_attachment','profile_picture', 'address', 'personal_num',
        'professional_num', 'pin', 'puk', 'salary', 'is_anapec', 'is_project', 'hours', 'ice','training_type','school',
        'professional_email', 'cnss', 'assurance', 'user_id', 'department_id','operator_id' , 'status_id'
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
