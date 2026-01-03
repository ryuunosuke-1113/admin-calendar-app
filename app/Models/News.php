<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
protected $fillable = ['title', 'importance', 'body', 'user_id'];

public function user()
{
    return $this->belongsTo(User::class);
}

public function comments()
{
    return $this->hasMany(Comment::class)->whereNull('parent_id')->latest();
}


}
