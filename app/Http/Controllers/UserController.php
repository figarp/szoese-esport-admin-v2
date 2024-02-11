<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Gate;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::all();
            return view('dashboard.admin.index', compact('users'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.admin.user_management.edit-user', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        try {
            $user = User::findOrFail($id);

            $user->update(request()->all());

            return redirect()->route('dashboard.admin.userManagement.edit', $user->id)->with('success', 'Sikeres frissítés');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function joinGroup($groupId)
    {
        try {
            if (!Gate::allows('join_group', $groupId)) {
                return redirect()->route('dashboard.groups.index')->with('error', 'Nincs jogosultságod ehhez a tevékenységez!');
            }

            $user = auth()->user();
            $group = Group::findOrFail($groupId);

            // Ellenőrizzük, hogy a felhasználó már csatlakozott-e a csoportba
            if ($user->groups()->where('group_id', $groupId)->exists()) {
                return redirect()->route('dashboard.groups.index')->with('error', 'Már csatlakoztál ebbe a csoportba!');
            }

            $group->addMember($user->id);

            return redirect()->route('dashboard.groups.index')->with('success', 'Sikeresen csatlakoztál a csoportba!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }

    public function leaveGroup($groupId)
    {
        try {
            if (!Gate::allows('leave_group', $groupId)) {
                return redirect()->route('dashboard.groups.index')->with('error', 'Nincs jogosultságod ehhez a tevékenységez!');
            }

            $user = auth()->user();
            $group = Group::findOrFail($groupId);

            if (!$user->groups()->where('group_id', $groupId)->exists()) {
                return redirect()->route('dashboard.groups.index')->with('error', 'Nem vagy tagja ennek a csoportnak!');
            }

            $application = Application::where('user_id', $user->id)->where('group_id', $group->id)->first();

            $group->removeMember($user->id);
            if ($application) {
                $application->delete();
            }

            return redirect()->route('dashboard.groups.index')->with('success', 'Sikeresen kiléptél a csoportból!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }
}