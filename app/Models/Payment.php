<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['payment_type_id', 'gross', 'employee_id','cnss' , 'tax_rate', 'income_tax','net'];

    public function employee() { return $this->belongsTo(Employee::class); }
    public function paymentType() { return $this->belongsTo(PaymentType::class); }
}
