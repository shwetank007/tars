<?php

namespace App\Http\Controllers\Control;

use App\Hero;
use App\Http\Controllers\Controller;
use App\Power;
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
        $data = json_decode($request->hero);

        DB::beginTransaction();
            $hero = new Hero();
            $hero->actor    = $data->actor;
            $hero->name     = $data->name;
            $hero->partner  = $data->partner;
            $hero->rival    = $data->rival;
            $hero->detail   = $data->detail;
            if ($request->hasFile('avatar')) {
                $file = Input::file('avatar');
                $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                $name = $timestamp . '-' . $file->getClientOriginalName();
                $hero->avatar = $name;
                $file->move(public_path() . '/images/', $name);
            } else {
                $hero->avatar = 'default.gif';
            }
            $hero->save();

            for($i = 0; $i < count($data->power); $i++) {
                $power = new Power();
                $power->hero_id     = $hero->id;
                $power->power_name  = $data->power[$i]->name;
                $power->damage      = $data->power[$i]->damage;
                $power->save();
            }
        DB::commit();
//        ,'avatar' => $hero->avatar]
        return response()->json(['status'=>'success'], 200);
    }

    public function destroy($id)
    {
        Hero::destroy($id);
        return response()->json(['status'=>'success'],200);
    }
}
