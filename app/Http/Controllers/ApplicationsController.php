<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Group;
use App\Models\User;
use App\Notifications\ApplicationAcceptedNotification;
use App\Notifications\ApplicationNotification;
use App\Notifications\ApplicationRejectedNotification;

class ApplicationsController extends Controller
{
    public function accept($id)
    {
        try {
            $application = Application::findOrFail($id);
            $application->update(['status' => 'accepted']);

            $user = User::findOrFail($application->user_id);
            $group = Group::findOrFail($application->group_id);

            if ($user->groups()->where('group_id', $group->id)->exists()) {
                return redirect()->back()->with('error', 'A felhasználó már tagja a csoportodnak!');
            }

            $group->addMember($user->id);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }

        $application->user->notify(new ApplicationAcceptedNotification($application));
        return redirect()->back()->with('success', 'A jelentkezés elfogadva!');
    }

    public function reject($id)
    {
        try {
            $application = Application::findOrFail($id);
            $application->update(['status' => 'rejected']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }

        $application->user->notify(new ApplicationRejectedNotification($application));
        return redirect()->back()->with('success', 'A jelentkezés elutasítva!');
    }

    public function store()
    {
        try {
            $application = Application::create(request()->all());
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }

        $delay = now()->addMinutes(1);
        $application->group->leader->notify((new ApplicationNotification($application))->delay($delay));

        return redirect()->back()->with('success', 'Feladva! A jelentkezésed módosíthatod a Jelentkezések fül alatt!');
    }

    public function index()
    {
        try {
            $users_applications = auth()->user()->applications()->orderBy('created_at', 'desc')->get();

            $incoming_applications = Application::whereHas('group', function ($query) {
                $query->where('leader_id', auth()->user()->id);
            })->orderBy('created_at', 'desc')->get();

            return view('dashboard.applications.index', compact('users_applications', 'incoming_applications'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }

    public function destroy(string $id)
    {
        try {
            $application = Application::findOrFail($id);

            $user = $application->user;
            $group = $application->group;

            $group->removeMember($user->id);
            $application->delete();

            return redirect()->back()->with('success', 'Jelentkezés visszavonva!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }
}