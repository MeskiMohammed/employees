<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['name', 'attachment', 'type_employee_id'];

    public function typeEmployee() { return $this->belongsTo(TypeEmployee::class); }

}
