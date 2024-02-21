<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewPostNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Notification;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            $search = $request->query('search');

            $query = Post::visibleToUser($user);

            // Ha van keresési feltétel, alkalmazzuk azt a címre
            if ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            }

            $posts = $query->orderBy('created_at', 'desc')->paginate(5);

            return view('dashboard.posts.index', compact('posts'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }
    }

    public function create()
    {
        $groups = Group::select('id', 'game')->get();
        return view('dashboard.posts.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:2500',
            'image' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $post = null;

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
            $post->visibility = $request->visibility;
            $post->save();

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ismeretlen hiba történt...');
        }

        if ($post) {
            $visibility = $post->visibility;
            $users = [];

            if ($visibility == 0 && $request->important !== null) {
                $users = User::all();
            } else {
                $group = Group::find($visibility);
                if ($group) {
                    $users = $group->members()->get();
                }
            }

            Notification::send($users, new NewPostNotification($post));
        }

        return redirect()->route('dashboard.posts.index')->with('success', 'Bejegyzés létrehozva!');
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
            'slug' => 'required|string|max:2500',
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