<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_room_id',
        'title',
        'image',
        'description',
    ];

    public function userRoom()
    {
        return $this->belongsTo(User::class);
    }
}
