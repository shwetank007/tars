<?php

namespace App\Http\Controllers\Control;

use App\Hero;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

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
        dd($request->power_name);
        DB::beginTransaction();
            $hero = new Hero();
            $hero->actor    = $request->get('actor');
            $hero->name     = $request->get('name');
            $hero->weakness = $request->get('weakness');
            $hero->partner  = $request->get('partner');
            $hero->rival    = $request->get('rival');
            $hero->detail   = $request->get('detail');
            if ($request->hasFile('avatar')) {
                $file = Input::file('avatar');
                $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                $name = $timestamp . '-' . $file->getClientOriginalName();
                $hero->avatar = $name;
                $file->move(public_path() . '/images/', $name);
            }
            $hero->save();

        DB::commit();
        return response()->json(['status'=>'success','avatar' => $hero->avatar],200);
    }

    public function destroy($id)
    {
        Hero::destroy($id);
        return response()->json(['status'=>'success'],200);
    }
}
