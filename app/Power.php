<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Power extends Model
{
    protected $fillable = [
        'hero_id', 'villain_id', 'power_name', 'damage',
    ];

    public function hero() {
        return $this->belongsTo(Hero::class,'hero_id');
    }

    public function villain() {
        return $this->belongsTo(Villain::class,'hero_id');
    }
}
