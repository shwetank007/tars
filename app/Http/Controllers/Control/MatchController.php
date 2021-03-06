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

        return response()->json(['fixture'=>$match,'heroes'=>$hero,'antiHeroes'=>$villain,'power'=>$power]);
    }

    public function show($id)
    {
        $match          = Match::with('hero','villain')->find($id);
        $powerHero      = Power::with('hero')->where('hero_id', $match->hero->id)->get();
        $powerVillain   = Power::with('villain')->where('villain_id', $match->villain->id)->get();

        return response()->json(['fixture'=>$match,'powerHero'=>$powerHero,'powerVillain'=>$powerVillain]);
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

        $data = Match::with('hero','villain')->find($match->id);

        return response()->json(['status'=>'success','match'=>$data],200);
    }

   public function destroy($id)
    {
        Match::destroy($id);
        return response()->json(['status'=>'success'],200);
    }
}