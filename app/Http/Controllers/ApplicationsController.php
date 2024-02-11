<?php

namespace App\Http\Controllers;

use App\Mail\NewApplicationMail;
use App\Models\Application;
use App\Models\Group;
use App\Models\User;
use Mail;

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

            return redirect()->back()->with('success', 'A jelentkezés elfogadva!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }

    public function reject($id)
    {
        try {
            $application = Application::findOrFail($id);
            $application->update(['status' => 'rejected']);

            return redirect()->back()->with('success', 'A jelentkezés elutasítva!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }

    public function store()
    {
        try {
            $application = Application::create(request()->all());

            $applicant = User::findOrFail($application->user_id);
            $group = Group::findOrFail($application->group->id);
            $leader = User::findOrFail($application->group->leader->id);

            $title = 'Kedves ' . $leader->first_name . '!';
            $body = '
                <p>Új jelentkezés érkezett a(z) <strong>' . $group->game . '</strong> csoportodba.</p>

                <h3>A Jelentkező adatai: </h3>
                <strong>Név</strong>: ' . $applicant->full_name() . '
                <strong>Felhasználónév</strong>: ' . $applicant->username . '
                <strong>Email cím</strong>: ' . $applicant->email . '
                <strong>Jelentkezés dátuma</strong>: ' . $application->created_at . '

                <p>Vedd fel a kapcsolatot a jelentkezővel az email címén keresztül, majd a weboldalon fogadd el vagy utasítsd el a jelentkezését!</p>
            ';

            $data = [
                'subject' => "Új Jelentkezés - SZoESE E-Sport",
                'applicant' => $applicant,
                'leader' => $leader,
                'group' => $group,
                'application' => $application,
                'title' => $title,
                'body' => $body,
            ];

            Mail::to($data["leader"])->send(new NewApplicationMail($data));

            return redirect()->back()->with('success', 'Feladva! A jelentkezésed módosíthatod a Jelentkezések fül alatt!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
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