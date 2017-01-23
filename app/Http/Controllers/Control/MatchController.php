<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Match;
use Illuminate\Support\Facades\DB;

class MatchController extends Controller
{
    public function index()
    {
        $villain = DB::table('villains')
            ->get();
        $hero = DB::table('heroes')
            ->get();
        $match = DB::table('matches')
            ->get();
        $power = DB::table('powers')
            ->get();
        return response()->json(['fixture'=>$match,'heros'=>$hero,'aVillain'=>$villain,'power'=>$power]);
    }

   public function store(Request $request)
    {
        DB::beginTransaction();

            $match = new Match();
            $match->actor   = $request->get('actor');
            $match->cause   = $request->get('cause');
            $match->place   = $request->get('place');
            $match->detail  = $request->get('detail');
            $match->date    = $request->get('date');
            $match->save();

        DB::commit();

        return response()->json(['status'=>'success'],200);
    }

   public function destroy($id)
    {
        Match::destroy($id);
        return response()->json(['status'=>'success'],200);
    }
}