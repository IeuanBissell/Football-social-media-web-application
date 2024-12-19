<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    public function canEdit(User $user)
    {
        if ($user->role->title === 'Admin') {
            return true;
        }
        return $this->user_id === $user->id;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
