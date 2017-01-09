<?php

namespace App\Http\Controllers\Control;

use App\Hero;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HeroController extends Controller
{
    public function index()
    {
        $hero = DB::table('heroes')
            ->get();
        
        return response()->json($hero);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

            $hero = new Hero();
            $hero->actor    = $request->get('actor');
            $hero->name     = $request->get('name');
            $hero->weakness = $request->get('weakness');
            $hero->partner  = $request->get('partner');
            $hero->rival    = $request->get('rival');
            $hero->detail   = $request->get('detail');
            $hero->save();
            
        DB::commit();

        return response()->json(['status'=>'success'],200);
    }

    public function destroy($id)
    {
        Hero::destroy($id);
        return response()->json(['status'=>'success'],200);
    }
}
