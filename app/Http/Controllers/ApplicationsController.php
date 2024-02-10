<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Group;
use App\Models\User;

class ApplicationsController extends Controller
{
    public function accept($id)
    {
        $application = Application::findOrFail($id);
        $application->update(['status' => 'accepted']);

        $user = User::findOrFail($application->user_id);
        $group = Group::findOrFail($application->group_id);

        // Ellenőrizzük, hogy a felhasználó már csatlakozott-e a csoportba
        if ($user->groups()->where('group_id', $group->id)->exists()) {
            return redirect()->back()->with('error', 'A felhasználó már tagja a csoportodnak!');
        }

        $group->addMember($user->id);

        return redirect()->back()->with('success', 'A jelentkezés elfogadva!');
    }

    public function reject($id)
    {
        $application = Application::findOrFail($id);
        $application->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'A jelentkezés elutasítva!');
    }

    public function store()
    {
        Application::create(request()->all());

        return redirect()->back()
            ->with('success', 'Jelentkezés feladva!');
    }

    public function index()
    {
        $users_applications = auth()->user()->applications()->orderBy('created_at', 'desc')->get();

        $incoming_applications = Application::whereHas('group', function ($query) {
            $query->where('leader_id', auth()->user()->id);
        })->orderBy('created_at', 'desc')->get();

        return view('dashboard.applications.index', compact('users_applications', 'incoming_applications'));
    }

    public function destroy(string $id)
    {
        $application = Application::findOrFail($id);

        $user = $application->user;
        $group = $application->group;

        $group->removeMember($user->id);

        $application->delete();

        return redirect()->back()
            ->with('success', 'Jelentkezés visszavonva!');
    }
}