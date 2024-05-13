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
     * Check if the user has the specified role.
     *
     * @param int|string $role
     * @return bool
     */
    public function hasRole($role)
    {
        // Implement your logic to check if the user has the specified role.
        // For example, if the role is stored in a column named 'role' in the users table:
        return $this->role == $role;
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
    protected $attributes = [];

    /**
     * Initialize default values for attributes.
     */
    protected function initializeDefaultValues()
    {
        // Set default values for the attributes
        $this->attributes['profile_photo'] = $this->getDefaultProfilePhoto();
    }

    /**
     * Get the default profile photo based on user's gender.
     *
     * @return string
     */
    protected function getDefaultProfilePhoto()
    {
        switch ($this->attributes['gender']) {
            case 'male':
                return 'storage/profile-photos/default/male.png';
            case 'female':
                return 'storage/profile-photos/default/female.png';
            case 'non-binary':
                return 'storage/profile-photos/default/unisex.png';
            default:
                return 'storage/profile-photos/default/user.png'; // Default fallback
        }
    }

    /**
     * Boot the model.
     */
    protected static function booted()
    {
        // Set default values for new model instances
        static::creating(function ($model) {
            $model->initializeDefaultValues();
        });
    }
}
