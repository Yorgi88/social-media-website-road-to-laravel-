<?php

namespace App\Models;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    //
    use Searchable;
    protected $fillable = ['title', 'body', 'user_id', 'timestamps', 'avatar'];

    public function toSearchableArray(){
        // the method name has to be exactly this!
        return ['title' => $this->title, 'body' => $this->body];  //specify the database row that should be searchable
    }
    
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
