<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::all();
        return view('dashboard.groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'game' => 'required|unique:groups',
            'leader_id' => 'required'
        ]);

        $group = Group::create($request->all());
        $group->users()->attach($request->leader_id, ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        return redirect()->route('dashboard.groups.index')
            ->with('success', 'Új csoport sikeresen létrehozva!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('dashboard.groups.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(string $id)
    {
        $group = Group::findOrFail($id);
        return view('dashboard.groups.edit', compact('group'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $group = Group::findOrFail($id);
        $request->validate([
            'game' => 'required|unique:groups,game,' . $group->id,
        ]);

        $group->update($request->all());

        return redirect()->route('dashboard.groups.index')
            ->with('success', 'Csoport sikeresen frissítve!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = Group::findOrFail($id);

        $group->delete();

        return redirect()->route('dashboard.groups.index')
            ->with('success', 'Csoport törölve!');
    }


    public function searchLeaders(Request $request)
    {
        $query = $request->input('query');

        // Keresés a teljes név alapján
        $leaders = User::whereRaw("CONCAT(last_name, ' ', first_name) LIKE '%" . $query . "%'")->get();

        // Átalakítjuk a vezetők tömbjét a megfelelő formátumba
        $formattedLeaders = $leaders->map(function ($leader) {
            // Összefűzzük a first_name és last_name változókat egy szóközzel
            $fullName = $leader->last_name . ' ' . $leader->first_name;

            // Visszaadjuk csak az "id" és "full_name" értékeket JSON formátumban
            return [
                'id' => $leader->id,
                'full_name' => $fullName,
            ];
        });

        // Válasz JSON formátumban az átalakított vezetőkkel
        return response()->json(['leaders' => $formattedLeaders]);
    }

}