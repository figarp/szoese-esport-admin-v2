<?php

namespace App\Http\Controllers;

use App\Mail\NewApplicationMail;
use App\Models\Application;
use App\Models\Group;
use App\Models\Image;
use App\Models\User;
use App\Notifications\KickedOutNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mail;

class GroupController extends Controller
{
    public function index()
    {
        try {
            $groups = Group::all();
            return view('dashboard.groups.index', compact('groups'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }

    public function indexPublic()
    {
        try {
            $groups = Group::all();
            return view('groups.index', compact('groups'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }

    }

    public function create()
    {
        return view('dashboard.groups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'game' => 'required|unique:groups',
            'leader_id' => 'required',
            'image' => 'required|image|dimensions:min_width=128,min_height=128,max_width=512,max_height=512',
        ]);

        try {
            $path = $request->file('image')->store('public/images');

            $image = new Image();
            $image->path = $path;
            $image->created_by = auth()->user()->id;
            $image->save();

            $group = new Group();
            $group->game = $request->game;
            $group->leader_id = $request->leader_id;
            $group->description = $request->description;
            $group->image_id = $image->id;
            $group->save();

            $group->addMember($request->leader_id);

            return redirect()->route('dashboard.groups.index')->with('success', 'Új csoport sikeresen létrehozva!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }

    public function show(string $id)
    {
        $group = Group::findOrFail($id);
        return view('dashboard.groups.show', compact('group'));
    }

    public function showPublic(string $id)
    {
        $group = Group::findOrFail($id);
        return view('groups.show', compact('group'));
    }

    public function edit(string $id)
    {
        $group = Group::findOrFail($id);
        return view('dashboard.groups.edit', compact('group'));
    }

    public function update(string $id)
    {
        $group = Group::findOrFail($id);
        request()->validate([
            'game' => 'required|unique:groups,game,' . $group->id,
        ]);

        try {
            if (request('leader_id') != $group->leader->id) {
                $errors = $group->setLeader(request('leader_id'));
                if (strlen($errors) > 0) {
                    return redirect()->route('dashboard.groups.index')->with('error', $errors);
                }
            }

            $group->update(request()->all());

            return redirect()->route('dashboard.groups.index')->with('success', 'Csoport sikeresen frissítve!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }

    public function destroy(string $id)
    {
        try {
            $group = Group::findOrFail($id);

            $group->removeAllMembers();

            $group->delete();

            return redirect()->route('dashboard.groups.index')
                ->with('success', 'Csoport törölve!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }

    public function searchLeaders(Request $request)
    {
        try {
            $query = $request->input('query');

            $leaders = User::whereRaw("CONCAT(last_name, ' ', first_name) LIKE '%" . $query . "%'")->get();

            $formattedLeaders = $leaders->map(function ($leader) {
                $fullName = $leader->last_name . ' ' . $leader->first_name;

                return [
                    'id' => $leader->id,
                    'full_name' => $fullName,
                ];
            });

            return response()->json(['leaders' => $formattedLeaders]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }

    public function kickFromGroup($groupId, $userId)
    {
        try {
            if (!\Gate::allows('manage_group_members', $groupId)) {
                return redirect()->back()->with('error', 'Nincs jogosultságod ehhez a tevékenységez!');
            }

            $user = User::findOrFail($userId);
            $group = Group::findOrFail($groupId);

            if (!$user->groups()->where('group_id', $groupId)->exists()) {
                return redirect()->route('dashboard.groups.index')->with('error', 'A felhasználó nem tagja a csoportodnak!');
            }

            $application = Application::where('user_id', $user->id)->where('group_id', $group->id)->first();

            $group->removeMember($user->id);
            if ($application) {
                $application->delete();
            }

            $user->notify(new KickedOutNotification($group, $user));

            return redirect()->back()->with('success', 'Felhasználó eltávolítva a csoportodból!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }
}