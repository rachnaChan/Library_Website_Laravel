<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;


    public $timestamps = false;
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'image',
        'user_event_id'
    ];

    public function UserEvent()
    {
        return $this->belongsTo(User::class);
    }
}
