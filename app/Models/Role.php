<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * Define the relationship with the SubRole model.
     */
    public function subRoles()
    {
        return $this->hasMany(SubRole::class);
    }

    protected $fillable = [
        'name',
    ];
}

