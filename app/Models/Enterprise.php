<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    protected $table = 'entreprise';
    protected $fillable = ['name','image'];
}
