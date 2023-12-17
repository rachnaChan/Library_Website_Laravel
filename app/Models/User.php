<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\resetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'role_id',
        'image',
        'gender',
        'dob',
        'bio',
        'phone_number'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function roleUser()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function Books()
    {
        return $this->hasMany(Books::class);
    }

    public function Rooms()
    {
        return $this->hasMany(Rooms::class);
    }

    public function Events()
    {
        return $this->hasMany(Events::class);
    }

    public function BookCategoriesUser()
    {
        return $this->hasMany(Categories::class,'user_categories_id')->with(['Books']);
    }

    public function favBooks(){
        return $this->hasMany(Favorite_Book::class,'favorite_book_id')->with(['Books']);
    }

    public function sendPasswordResetNotification($token)
    {
        $url = 'http://localhost:5173/newPassword?token=' . $token;
        $this->notify(new resetPassword($url));
    }
}
