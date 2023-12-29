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
        'categories_type',
        'release_year',
        'description',
        'image'

    ];

         //enum values for file_type's field
         public const TYPE_GIC = 'GIC';
         public const TYPE_AMS = 'AMS';
         public const TYPE_GIM = 'GIM';
         public const TYPE_GCA = 'GCA';
         public const TYPE_GEE = 'GEE';
         public const TYPE_OAC = 'OAC';
         public const TYPE_GGG = 'GGG';
         public const TYPE_GTR = 'GTR';



    public function userBook(){
        return $this->belongsTo(User::class);
    }


    public function userBooks(){
        return $this->hasMany(User::class);
    }


}
