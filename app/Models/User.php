<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password', 
        'avatar',
    ];

    protected function avatar(): Attribute {
        return Attribute::make(get: function($value){
            // lets filter what the incoming value of avatar is to be
            // so we say if the user's avatar field is null, use a default image
            return $value ? '/storage/user_avatars/' . $value : 'fallback-avatar.jpg';
        });
    }

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

    public function followers(){
        return $this->hasMany(Follow::class, 'followeduser');
        //a can user can have many followers
    }

    public function followingTheseUsers(){
        return $this->hasMany(Follow::class, 'user_id');
        //returns whoever the user is following
        //see the learn.md file for more explanation
    }

    public function posts(){
        //a user can have many posts
        return $this->hasMany(Post::class, 'user_id');
    }
    

    //for the user homepage feed => to get the other users posts in the homepage
    public function feedPosts(){
        return $this->hasManyThrough(
            Post::class,
            Follow::class,
            'user_id',
            'user_id',
            'id',
            'followeduser'
        );
    }


    
}
