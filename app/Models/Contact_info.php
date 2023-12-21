<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact_info extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'phone_number',
        'address',
        'websites',
        'country',
        'user_id',
        'fax',
        'facebook',
        'telegram',
        'youtube',
    ];

    public function userBook(){
        return $this->belongsTo(User::class);
    }

}
