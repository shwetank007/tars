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
        $match = DB::table('matches')
            ->get();
        return response()->json($match);
    }

   public function store(Request $request)
    {
        DB::beginTransaction();

            $match = new Match();
            $match->actor = $request->get('actor');
            $match->cause = $request->get('cause');
            $match->place = $request->get('place');
            $match->detail = $request->get('detail');
            $match->save();

        DB::commit();
    }

   public function destroy($id)
    {
        Match::destroy($id);
        return response()->json(['status'=>'success'],200);
    }
}