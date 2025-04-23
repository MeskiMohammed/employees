<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $fillable = ['operator'];

    public function employees(){return $this->hasMany(Employee::class);}
}
