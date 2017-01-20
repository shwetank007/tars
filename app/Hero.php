<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $fillable = [
    	'actor', 'name', 'weakness', 'rival', 'partner',
    ];

    public static function rules($action, $id=null) {
        $rules = [
            'add' => [
                'actor' =>  'required|'
            ]
        ];
    }
}
