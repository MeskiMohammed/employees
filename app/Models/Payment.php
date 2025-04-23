<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['payment_id', 'salary', 'employee_id', 'date', 'tax', 'net'];

    public function employee() { return $this->belongsTo(Employee::class); }
    public function type() { return $this->belongsTo(PaymentType::class); }
}
