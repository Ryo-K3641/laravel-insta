<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Post extends Model
{
    use HasFactory;

    # A post belongs to a user
    # Use this method to get the owner of the post
    public function user(){
        return $this->belongsTo(User::class);
    }

    # Use this method to get the categories of the post
    public function categoryPost(){
        return $this->hasMany(categoryPost::class);
    }

    # Use this method to get the comments under the post
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    
}
