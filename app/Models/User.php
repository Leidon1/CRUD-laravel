<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    /**
     * Define the relationship with the Role model.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'username',
        'email',
        'gender',
        'profile_photo',
        'country',
        'birthday',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'profile_photo' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birthday' => 'date:Y-m-d',
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * The format of the "created_at" and "last_login" attributes.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';
    /**
     * The attributes that should have default values.
     *
     * @var array
     */
    protected $attributes = [
        'profile_photo' => 'https://media.licdn.com/dms/image/C4E0BAQGiEj7SiyhMUA/company-logo_200_200/0/1668178088214/we_web_developers_logo?e=2147483647&v=beta&t=PPaEYSJkqAzTxGeMaBM_7OvyNYTYYNWiQZW85vLvDZ8',
    ];
}
