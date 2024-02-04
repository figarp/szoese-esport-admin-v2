<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Group;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('create_group', function ($user) {
            return $user->hasPermission('create_group');
        });
        Gate::define('edit_group', function ($user, $groupId) {
            $group = Group::findOrFail($groupId);
            return ($user->hasPermission('edit_group') && $group->leader->id == $user->id) || $user->hasRole('admin');
        });
        Gate::define('delete_group', function ($user) {
            return $user->hasPermission('delete_group');
        });
        Gate::define('manage_group_members', function ($user) {
            return $user->hasPermission('manage_group_members');
        });
        Gate::define('join_group', function ($user, $groupId) {
            $group = Group::findOrFail($groupId);
            return $user->hasPermission('join_groups') && !$group->members->contains($user->id);
        });
        Gate::define('leave_group', function ($user, $groupId) {
            $group = Group::findOrFail($groupId);
            return $user->hasPermission('leave_groups') && $group->members->contains($user->id);
        });
    }
}