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
                $power->villain_id = $request->villain_id;
            }

        DB::commit();

        $data = Power::find($power->id);

        return response()->json(['status'=>'success','power'=>$data],200);
    }

    public function update(Request $request, $id)
    {
        dd('update');
    }

    public function destroy($id)
    {
        dd('destroy');
    }
}
