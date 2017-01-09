<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Villain extends Model
{
    protected $fillable = [
    	'actor', 'name', 'rival', 'partner',
    ];
}
