<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    use HasFactory;

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }
}
