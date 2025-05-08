<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Status extends Model
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
    
    protected $fillable = ['status'];
    public function employees() { return $this->hasMany(Employee::class); }
}
