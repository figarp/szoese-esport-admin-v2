<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index()
    {
        try {
            $images = Image::where('user_id', auth()->id())->get();
            return view('images.index', compact('images'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
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

        try {
            $path = $request->file('image')->store('images');

            $image = new Image();
            $image->path = $path;
            $image->user_id = auth()->id();
            $image->save();

            return redirect()->back()->with('success', 'Kép sikeresen feltöltve!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($imgId)
    {
        try {
            $image = Image::findOrFail($imgId);

            if ($image->user_id != auth()->id()) {
                return redirect()->back()->with('error', 'Nem törölheted ezt a képet!');
            }

            if (file_exists(public_path($image->path))) {
                unlink(public_path($image->path));
            }

            $image->delete();

            return redirect()->back()->with('success', 'Kép törölve!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }
}
