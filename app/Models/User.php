<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'username',
        'email',
        'password'
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
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function full_name()
    {
        return $this->last_name . ' ' . $this->first_name;
    }

    /**
     * Get the groups that the user belongs to.
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_users');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function hasRole($roleName)
    {
        return $this->roles->contains('name', $roleName);
    }

    public function assignRole($roleName)
    {
        $role = Role::where('name', $roleName)->firstOrFail();
        $this->roles()->attach($role);
    }

    public function removeRole($roleName)
    {
        $role = Role::where('name', $roleName)->firstOrFail();
        $this->roles()->detach($role);
    }
}