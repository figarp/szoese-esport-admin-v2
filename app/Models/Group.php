<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'game',
        'description',
        'leader_id'
    ];

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function isUserMember($userId)
    {
        return $this->users()->where('user_id', $userId)->exists();
    }

    /**
     * Get the users who belong to the group.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'group_users');
    }

    /**
     * Get the count of users who belong to the group.
     */
    public function usersCount()
    {
        return $this->users()->count();
    }

    public function shortDescription()
    {
        $shortDescription = substr($this->description, 0, 73);
        if (strlen($this->description) > 73) {
            $shortDescription .= '...';
        }
        return $shortDescription;
    }
}