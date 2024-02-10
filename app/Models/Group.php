<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function setLeader($newLeaderId)
    {
        $old_leader = User::findOrFail($this->leader->id);
        $newLeader = User::findOrFail($newLeaderId);
        $error = "";

        if (!$this->members->contains($newLeaderId)) {
            // Ha nem, akkor hibaüzenetet adunk vissza
            $error = "A megadott felhasználó még nem tagja a csoportnak!";
            return $error;
        }

        if (!auth()->user()->can('edit_group', $this->id)) {
            // Ha nem, akkor hibaüzenetet adunk vissza
            $error = "Nincs jogosultságod a csoport vezetőjének megváltoztatásához!";
            return $error;
        }

        if ($old_leader->id == $newLeaderId) {
            // Ha igen, akkor hibaüzenetet adunk vissza
            $error = "A megadott felhasználó már a csoport vezetője!";
            return $error;
        }

        if (!$newLeader->hasRole('csoportvezeto')) {
            $newLeader->assignRole('csoportvezeto');
        }

        if ($old_leader->leadingGroups()->count() <= 1) {
            $old_leader->removeRole('csoportvezeto');
        }

        $this->leader_id = $newLeaderId;
        $this->save();
        return $error;
    }

    public function isUserMember($userId)
    {
        return $this->members()->where('user_id', $userId)->exists();
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_users', 'group_id', 'user_id')
            ->withTimestamps();
    }

    public function memberJoinedAt($memberId)
    {
        return $this->members()->where('user_id', $memberId)->first()->pivot->created_at;
    }

    public function membersCount()
    {
        return $this->members()->count();
    }

    public function addMember($userId)
    {
        if ($this->members->contains($userId))
            return;

        $user = User::findOrFail($userId);
        if (!$user->hasRole('tag')) {
            $user->assignRole('tag');
        }

        if ($this->leader->id == $user->id && !$user->hasRole('csoportvezeto')) {
            $user->assignRole('csoportvezeto');
        }

        $this->members()->attach($userId, [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    public function removeMember($userId)
    {
        if (!$this->members->contains($userId))
            return;

        $user = User::findOrFail($userId);

        if ($user->groups()->count() <= 1) {
            $user->removeRole('tag');
        }
        if ($this->leader->id == $user->id && $user->leadingGroups()->count() <= 1) {
            $user->removeRole('csoportvezeto');
        }

        $this->members()->detach($userId);
    }

    public function removeAllMembers()
    {
        $this->members->each(function ($user) {
            $this->removeMember($user->id);
        });
    }

    public function shortDescription()
    {
        $shortDescription = substr($this->description, 0, 73);
        if (strlen($this->description) > 73) {
            $shortDescription .= '...';
        }
        return $shortDescription;
    }

    public function incomingApplications()
    {
        return Application::where('group_id', $this->id)->get();
    }


}