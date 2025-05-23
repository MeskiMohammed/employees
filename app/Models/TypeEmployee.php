<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeEmployee extends Model
{
    protected $fillable = ['description','type_id', 'employee_id', 'in_date', 'out_date'];

    protected $casts = [
        'in_date' => 'date', 
        'out_date' => 'date'
    ];

    public function employee() { return $this->belongsTo(Employee::class); }
    public function type() { return $this->belongsTo(Type::class); }
    public function attachments() { return $this->hasMany(Attachment::class); }

}
