<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubRole extends Model
{
    protected $fillable = [
        'name',
        'role_id',
    ];

    /**
     * Define the relationship between SubRole and Role.
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
