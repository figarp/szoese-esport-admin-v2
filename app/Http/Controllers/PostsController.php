<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function index()
    {
        try {
            $posts = Post::orderBy('created_at', 'desc')->paginate(10);
            return view('dashboard.posts.index', compact('posts'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }

    public function create()
    {
        return view('dashboard.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:2500|unique:posts',
            'image' => 'required|image|mimes:jpeg,png,jpg|size:2048',
        ]);

        try {
            $path = $request->file('image')->store('public/images');

            $image = new Image();
            $image->path = $path;
            $image->created_by = auth()->user()->id;
            $image->save();

            $post = new Post();
            $post->title = $request->title;
            $post->slug = $request->slug;
            $post->image_id = $image->id;
            $post->author_id = auth()->user()->id;
            $post->save();

            return redirect()->route('dashboard.posts.index')->with('success', 'Bejegyzés létrehozva!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('dashboard.posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('dashboard.posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $post->id,
        ]);

        try {
            $post->update($request->all());

            return redirect()->route('dashboard.posts.index')->with('success', 'Bejegyzés frissítve!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }

    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);

            if ($post->image_id) {
                $image = Image::findOrFail($post->image_id);
                Storage::delete($image->path);
                $image->delete();
            }

            $post->delete();

            return redirect()->route('dashboard.posts.index')->with('success', 'Bejegyzés törölve!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }
}