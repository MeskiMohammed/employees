<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use LogsActivity;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->logCreation($model);
        });

        static::updated(function ($model) {
            $model->logUpdate($model);
        });

        static::deleted(function ($model) {
            $model->logDeletion($model);
        });
    }
    protected $fillable = ['operator'];

    public function employees(){return $this->hasMany(Employee::class);}
}
