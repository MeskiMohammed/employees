<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeePost extends Model
{
    protected $fillable = ['post'];
    public function postEmployees() { return $this->hasMany(PostEmployee::class); }

}
