<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use LogsActivity;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->logCreation($model);
        });
    }
    protected $fillable = ['payment_type_id', 'gross', 'employee_id','cnss' , 'tax_rate', 'income_tax','net'];

    public function employee() { return $this->belongsTo(Employee::class); }
    public function paymentType() { return $this->belongsTo(PaymentType::class); }
}
