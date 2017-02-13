<?php

namespace App\Http\Controllers\Control;

use App\Villain;
use App\Power;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

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
        $data = json_decode($request->villain);

        DB::beginTransaction();

            $villain = new Villain();
            $villain->actor    = $data->actor;
            $villain->name     = $data->name;
            $villain->partner  = $data->partner;
            $villain->rival    = $data->rival;
            $villain->detail   = $data->detail;
            if ($request->hasFile('avatar')) {
                $file = Input::file('avatar');
                $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                $name = $timestamp . '-' . $file->getClientOriginalName();
                $villain->avatar = $name;
                $file->move(public_path() . '/images/', $name);
            }
            $villain->save();

        for($i = 0; $i < count($data->power); $i++) {
                $power = new Power();
                $power->villain_id     = $villain->id;
                $power->power_name  = $data->power[$i]->name;
                $power->damage      = $data->power[$i]->damage;
                $power->save();
            }
        DB::commit();

        return response()->json(['status'=>'success'],200);
    }

    public function destroy($id)
    {
        Villain::destroy($id);
        return response()->json(['status'=>'success'],200);
    }
}
