<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    # Use this method to get the post under the category
    public function categoryPost(){
        return $this->hasMany(CategoryPost::class);
    }
}
