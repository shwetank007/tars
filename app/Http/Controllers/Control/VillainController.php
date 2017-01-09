<?php

namespace App\Http\Controllers\Control;

use App\Villain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class VillainController extends Controller
{
    public function index()
    {
        $villain = DB::table('villains')
            ->get();
        
        return response()->json($villain);   
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

            $hero = new Villain();
            $hero->actor    = $request->get('actor');
            $hero->name     = $request->get('name');
            $hero->partner  = $request->get('partner');
            $hero->rival    = $request->get('rival');
            $hero->detail   = $request->get('detail');
            $hero->save();

        DB::commit();

        return response()->json(['status'=>'success'],200);
    }

    public function destroy($id)
    {
        Villain::destroy($id);
        return response()->json(['status'=>'success'],200);
    }
}
