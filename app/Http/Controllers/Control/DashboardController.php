<?php

namespace App\Http\Controllers\Control;

use App\Hero;
use App\Http\Controllers\Controller;
use App\Match;
use App\Villain;

class DashboardController extends Controller
{

    public function index()
    {
        $hero = Hero::count();
        $villain = Villain::count();
        $match = Match::count();

        return response()->json(['hero' => $hero, 'villain' => $villain, 'match' => $match]);
    }

    public function refer()
    {
        return response()->view('welcome');
    }
}
