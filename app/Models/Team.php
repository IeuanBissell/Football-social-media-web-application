<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public function standing()
    {
        return $this->hasOne(Standing::class);
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
