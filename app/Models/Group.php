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

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id');
    }

    public function membersCount()
    {
        return $this->members()->count();
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