<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',

        ];
    }


    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }



    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlist()
{
    return $this->hasMany(WhishList::class);
}

}
