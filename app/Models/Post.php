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
}