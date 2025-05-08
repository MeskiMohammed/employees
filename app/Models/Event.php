<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'description',
        'model_type',
        'model_id',
        'ip_address',
        'user_agent',
        'properties'
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    /**
     * Get the user that performed the action.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related model.
     */
    public function subject()
    {
        return $this->morphTo('model');
    }


    public function scopeOfAction(Builder $query, $action)
    {
        if (!empty($action)) {
            $query->where('action', $action);
        }
        return $query;
    }

    public function scopeOfModelType(Builder $query, $modelType)
    {
        if (!empty($modelType)) {
            $query->where('model_type', $modelType);
        }
        return $query;
    }

    public function scopeOfUser(Builder $query, $userId)
    {
        if (!empty($userId)) {
            $query->where('user_id', $userId);
        }
        return $query;
    }

    public function scopeDateRange(Builder $query, $startDate, $endDate)
    {
        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif (!empty($startDate)) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif (!empty($endDate)) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        return $query;
    }
}
