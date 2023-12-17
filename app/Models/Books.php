<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Books extends Model
{
    use HasFactory;

    protected $_fillable=[
        'user_id',
        'isbn',
        'file_name',
        'file_path',
        'author',
        'categories_id',
        'release_year',
        'description',
        'image'

    ];

    public function userBook(){
        return $this->belongsTo(User::class);
    }

    public function CategoriesBook()
    {
        return $this->belongsTo(Categories::class);
    }

    public function userBooks(){
        return $this->hasMany(User::class);
    }


}
