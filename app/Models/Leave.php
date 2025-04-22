<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = ['start_date', 'end_date', 'reason', 'status', 'employee_id'];

    public function employee() { return $this->belongsTo(Employee::class); }
}
