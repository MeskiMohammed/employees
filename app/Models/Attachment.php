<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['name', 'attachment', 'employee_id'];

    public function employee() { return $this->belongsTo(Employee::class); }
}
