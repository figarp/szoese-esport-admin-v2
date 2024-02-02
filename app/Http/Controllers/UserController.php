<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

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
        $roles = Role::all();

        // Felhasználó adatainak átadása a szerkesztési nézetnek
        return view('dashboard.admin.user_management.edit-user', compact('user', 'roles'));
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
}