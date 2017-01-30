<?php

namespace App\Http\Controllers\Control;

use App\Hero;
use App\Power;
use App\Villain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Match;
use Illuminate\Support\Facades\DB;

class MatchController extends Controller
{
    public function index()
    {
        $villain = Villain::all();
        $hero= Hero::all();
        $match = Match::with('hero','villain')->get();
        $power = Power::all();

        return response()->json(['fixture'=>$match,'heros'=>$hero,'aVillain'=>$villain,'power'=>$power]);
    }

   public function store(Request $request)
    {
        DB::beginTransaction();

            $match = new Match();
            $match->hero_id     = $request->get('hero_id');
            $match->villain_id  = $request->get('villain_id');
            $match->cause       = $request->get('cause');
            $match->place       = $request->get('place');
            $match->detail      = $request->get('detail');
            $match->date        = $request->get('date');
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