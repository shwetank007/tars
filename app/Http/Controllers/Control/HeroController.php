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
        $hero = Hero::with('power')->get();
        
        return response()->json($hero);
    }

    public function show($id)
    {
        $hero = Hero::with('power')->find($id);

        return response()->json(['hero'=>$hero]);
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
                $file           = Input::file('avatar');
                $timestamp      = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                $name           = $timestamp . '-' . $file->getClientOriginalName();
                $hero->avatar   = $name;
                $file->move(public_path() . '/images/', $name);
            } else {
                $hero->avatar = 'default.gif';
            }
            $hero->save();

        DB::commit();

        return response()->json(['status'=>'success'], 200);
    }

    public function update(Request $request, $id)
    {
        $data = json_decode($request->hero);

        DB::beginTransaction();

            $hero = Hero::find($id);
            $hero->actor    = $data->actor;
            $hero->name     = $data->name;
            $hero->rival    = $data->rival;
            $hero->partner  = $data->partner;
            $hero->detail   = $data->detail;

            if ($request->hasFile('avatar')) {
                $file           = Input::file('avatar');
                $timestamp      = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                $name           = $timestamp . '-' . $file->getClientOriginalName();
                $hero->avatar   = $name;
                $file->move(public_path() . '/images/', $name);
            }

            $hero->save();

        DB::commit();

        return response()->json(['status'=>'success'], 200);
    }

    public function destroy($id)
    {
        Hero::destroy($id);
        return response()->json(['status'=>'success'],200);
    }
}
