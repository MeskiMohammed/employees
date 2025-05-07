<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreelancerProject extends Model
{
    protected $fillable = ['name', 'price', 'status', 'employee_id'];

    public function employee() { return $this->belongsTo(Employee::class); }
}
