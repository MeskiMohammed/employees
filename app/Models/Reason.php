<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    use HasFactory;
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

    protected $fillable = ['reason'];
    public function leaves() { return $this->hasMany(Leave::class); }

}
