<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
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
    protected $fillable = ['type'];
    public function typeEmployees() { return $this->hasMany(TypeEmployee::class); }

}
