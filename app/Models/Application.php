<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'group_id',
        'status',
    ];

    // Kapcsolat a felhasználókhoz
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Kapcsolat a csoportokhoz
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    // Elfogadott státusz beállítása
    public function accept()
    {
        $this->status = 'accepted';
        $this->save();
    }

    // Elutasított státusz beállítása
    public function reject()
    {
        $this->status = 'rejected';
        $this->save();
    }

    public function getStatus()
    {
        switch ($this->status) {
            case 'pending':
                return '<span class="text-warning">Elfogadásra vár...</span>';
            case 'accepted':
                return '<span class="text-success">Elfogadva</span>';
            case 'rejected':
                return '<span class="text-danger">Elutasítva</span>';
            default:
                return '<span>Ismeretlen státusz</span>';
        }
    }
}