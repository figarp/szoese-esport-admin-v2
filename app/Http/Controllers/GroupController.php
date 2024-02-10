<?php

namespace App\Http\Controllers;

use App\Models\Application;
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

    public function indexPublic()
    {
        $groups = Group::all();
        return view('groups.index', compact('groups'));
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
        $group->addMember($request->leader_id);

        return redirect()->route('dashboard.groups.index')
            ->with('success', 'Új csoport sikeresen létrehozva!');
    }

    /**
     * Display the specified resource.
     */
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
    public function update(string $id)
    {
        $group = Group::findOrFail($id);
        request()->validate([
            'game' => 'required|unique:groups,game,' . $group->id,
        ]);

        if (request('leader_id') != $group->leader->id) {
            $errors = $group->setLeader(request('leader_id'));
            if (strlen($errors) > 0) {
                return redirect()->route('dashboard.groups.index')->with('error', $errors);
            }
        }

        $group->update(request()->all());

        return redirect()->route('dashboard.groups.index')
            ->with('success', 'Csoport sikeresen frissítve!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = Group::findOrFail($id);

        $group->removeAllMembers();

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

    public function kickFromGroup($groupId, $userId)
    {
        if (!\Gate::allows('manage_group_members', $groupId)) {
            return redirect()->back()->with('error', 'Nincs jogosultságod ehhez a tevékenységez!');
        }

        $user = User::findOrFail($userId);
        $group = Group::findOrFail($groupId);

        // Ellenőrizzük, hogy a felhasználó valóban csatlakozott-e a csoportba
        if (!$user->groups()->where('group_id', $groupId)->exists()) {
            return redirect()->route('dashboard.groups.index')->with('error', 'A felhasználó nem tagja a csoportodnak!');
        }

        $application = Application::where('user_id', $user->id)->where('group_id', $group->id)->first();

        // Kilépés a csoportból
        $group->removeMember($user->id);
        if ($application) {
            $application->delete();
        }

        return redirect()->back()->with('success', 'Felhasználó eltávolítva a csoportodból!');
    }

}