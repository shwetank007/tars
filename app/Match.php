<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $fillable = [
        'actor', 'cause', 'place', 'detail',
    ];
}
