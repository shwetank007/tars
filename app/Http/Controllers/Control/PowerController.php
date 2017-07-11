<?php

namespace App\Http\Controllers\Control;

use App\Http\Controllers\Controller;
use App\Power;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PowerController extends Controller
{

    public function store(Request $request)
    {

        DB::beginTransaction();

            $power                  = new Power();
            $power->power_name      = $request->power_name;
            $power->damage          = $request->damage;

            if(isset($request->hero_id))
            {
                $power->hero_id     = $request->hero_id;
            } else {
                $power->villain_id  = $request->villain_id;
            }
            $power->save();
        DB::commit();

        $data = Power::find($power->id);

        return response()->json(['status'=>'success', 'power'=>$data], 200);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

            $power = Power::find($id);
            $power->power_name  = $request->power_name;
            $power->damage      = $request->damage;

            if(isset($request->hero_id))
            {
                $power->hero_id = $request->hero_id;
            } else {
                $power->villain_id  = $request->villain_id;
            }
            $power->save();
        DB::commit();

        $data = Power::find($id);

        return response()->json(['status'=>'success', 'power'=>$data], 200);
    }

    public function destroy($id)
    {
        Power::destroy($id);
        return response()->json(['status'=>'success'], 200);
    }
}
