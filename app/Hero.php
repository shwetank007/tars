<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $fillable = [
    	'avatar', 'actor', 'name', 'weakness', 'rival', 'partner',
    ];
}
