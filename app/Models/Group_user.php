<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group_user extends Model
{
    use HasFactory;

    protected $table = 'group_users';

    protected $fillable = [
        'user_id',
        'group_id'
    ];

    /**
     * Get the group that the user belongs to.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the user that belongs to the group.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}