<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Villain extends Model
{
    protected $fillable = [
    	'avatar', 'actor', 'name', 'rival', 'partner',
    ];
}
