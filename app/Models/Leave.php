<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = ['start_date', 'end_date', 'reason_id', 'status', 'employee_id'];

    public function employee() { return $this->belongsTo(Employee::class); }
    public function reason() { return $this->belongsTo(Reason::class); }

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}

