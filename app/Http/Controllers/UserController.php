<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;

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
        $user->update([
            'role_id' => request('role_id'),
        ]);

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
        $user = auth()->user();

        // Ellenőrizzük, hogy a felhasználó már csatlakozott-e a csoportba
        if ($user->groups()->where('group_id', $groupId)->exists()) {
            return redirect()->route('dashboard.groups.index')->with('error', 'Már csatlakoztál ehhez a csoportba!');
        }

        $group = Group::findOrFail($groupId);

        // Csatlakozás a csoportba
        $user->groups()->attach($group);

        return redirect()->route('dashboard.groups.index')->with('success', 'Sikeresen csatlakoztál a csoportba!');
    }


    public function leaveGroup($groupId)
    {
        $user = auth()->user();

        // Ellenőrizzük, hogy a felhasználó valóban csatlakozott-e a csoportba
        if (!$user->groups()->where('group_id', $groupId)->exists()) {
            return redirect()->route('dashboard.groups.index')->with('error', 'Nem vagy tagja ennek a csoportnak!');
        }

        $group = Group::findOrFail($groupId);

        // Kilépés a csoportból
        $user->groups()->detach($group);

        return redirect()->route('dashboard.groups.index')->with('success', 'Sikeresen kiléptél a csoportból!');
    }
}