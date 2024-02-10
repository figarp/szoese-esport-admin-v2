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
        $users = User::all();
        return view('dashboard.admin.index', compact('users'));
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
        // Felhasználó keresése az azonosító alapján
        $user = User::findOrFail($id);
        // Felhasználó adatainak átadása a szerkesztési nézetnek
        return view('dashboard.admin.user_management.edit-user', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        // Validálás
        $user = User::findOrFail($id);

        // Bejegyzés frissítése
        $user->update(request()->all());

        return redirect()->route('dashboard.admin.userManagement.edit', $user->id)
            ->with('success', 'Sikeres frissítés');
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
    }


    public function leaveGroup($groupId)
    {
        if (!Gate::allows('leave_group', $groupId)) {
            return redirect()->route('dashboard.groups.index')->with('error', 'Nincs jogosultságod ehhez a tevékenységez!');
        }

        $user = auth()->user();
        $group = Group::findOrFail($groupId);

        // Ellenőrizzük, hogy a felhasználó valóban csatlakozott-e a csoportba
        if (!$user->groups()->where('group_id', $groupId)->exists()) {
            return redirect()->route('dashboard.groups.index')->with('error', 'Nem vagy tagja ennek a csoportnak!');
        }

        $application = Application::where('user_id', $user->id)->where('group_id', $group->id)->first();

        // Kilépés a csoportból
        $group->removeMember($user->id);
        if ($application) {
            $application->delete();
        }

        return redirect()->route('dashboard.groups.index')->with('success', 'Sikeresen kiléptél a csoportból!');
    }
}