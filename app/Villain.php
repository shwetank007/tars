<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Villain extends Model
{
    protected $fillable = [
    	'avatar', 'actor', 'name', 'rival', 'partner',
    ];

    public function power() {
        return $this->hasMany(Power::class,'villain_id');
    }
}
