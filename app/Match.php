<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $fillable = [
        'hero_id', 'villain_id', 'cause', 'place', 'detail',
    ];

    public function hero()
    {
        return $this->hasOne(Hero::class, 'id', 'hero_id');
    }

    public function villain()
    {
        return $this->hasOne(Villain::class, 'id', 'villain_id');
    }
}
