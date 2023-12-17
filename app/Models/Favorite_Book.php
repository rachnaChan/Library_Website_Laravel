<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite_Book extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'favorite_books';
    protected $fillable = [
        'user_book_id',
        'favorite_book_id',
    ];

    public function userFavBook()
    {
        return $this->belongsTo(User::class);
    }

    public function UserFavBooks()
    {
        return $this->hasMany(Books::class);
    }
}
