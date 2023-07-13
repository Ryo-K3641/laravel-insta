<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;

    # Use this to get the info of the owner of the comment
    # 1 to Many relationship
    public function user(){
        return $this->belongsTo(User::class);
    }
}
