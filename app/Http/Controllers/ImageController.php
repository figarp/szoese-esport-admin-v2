<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Csak az aktuális felhasználó által feltöltött képek lekérése
        $images = Image::where('user_id', auth()->id())->get();
        return view('images.index', compact('images'));
    }

    public function create()
    {
        return view('create-image-form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048', // maximum 2MB
        ]);

        $path = $request->file('image')->store('images');

        $image = new Image();
        $image->path = $path;
        $image->user_id = auth()->id();
        $image->save();

        return redirect()->back()->with('success', 'Kép sikeresen feltöltve!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($imgId)
    {
        $image = Image::findOrFail($imgId);

        // Ellenőrizzük, hogy a felhasználó azonos-e a kép tulajdonosával
        if ($image->user_id != auth()->id()) {
            return redirect()->back()->with('error', 'Nem törölheted ezt a képet!');
        }

        // Képfájl törlése a szerverről
        if (file_exists(public_path($image->path))) {
            unlink(public_path($image->path));
        }

        // Adatbázisból törlés
        $image->delete();

        return redirect()->back()->with('success', 'Kép törölve!');
    }
}