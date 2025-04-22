<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = ['date', 'score', 'notes', 'employee_id'];

    public function employee() { return $this->belongsTo(Employee::class); }
}
