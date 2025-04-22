<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostEmployee extends Model
{
    protected $fillable = ['employee_post_id', 'employee_id', 'attachment', 'in_date', 'out_date'];

    public function employee() { return $this->belongsTo(Employee::class); }
    public function posts() { return $this->belongsTo(EmployeePost::class, 'employee_post_id'); }
}
