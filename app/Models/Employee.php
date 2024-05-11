<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        // Define the fillable fields here
        'name',
        'last_name',
        'email',
        'gender',
        'country',
        'birthday',
        'password',
    ];
}
