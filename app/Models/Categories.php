<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'categories_name',
        'user_categories_id',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_categories_id');
    }

    public function Books()
    {
        return $this->belongsTo(Books::class,'id');
    }


}
