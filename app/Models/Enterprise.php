<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($model) {
            $model->logUpdate($model);
        });
    }

    protected $fillable = ['name', 'logo'];
    protected $table='enterprise';
}
