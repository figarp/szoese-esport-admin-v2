<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image_id',
        'author_id'
    ];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopeVisibleToUser($query, $user)
    {
        return $query->where('visibility', 0)
            ->orWhereIn('visibility', $user->groups->pluck('id')->toArray());
    }

    public function group()
    {
        // Ha a visibility 0, akkor null értéket adunk vissza
        if ($this->visibility === 0) {
            return null;
        }

        // Ellenkező esetben visszaadjuk a csoportot a group_id alapján
        return Group::find($this->visibility) ?? null;
    }
}