<?php

namespace App\Http\Controllers\Control;

use App\Villain;
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
        DB::beginTransaction();

            $villain = new Villain();
            $villain->actor    = $request->get('actor');
            $villain->name     = $request->get('name');
            $villain->partner  = $request->get('partner');
            $villain->rival    = $request->get('rival');
            $villain->detail   = $request->get('detail');
            if ($request->hasFile('avatar')) {
                $file = Input::file('avatar');
                $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                $name = $timestamp . '-' . $file->getClientOriginalName();
                $villain->avatar = $name;
                $file->move(public_path() . '/images/', $name);
            }
            $villain->save();

        DB::commit();

        return response()->json(['status'=>'success','avatar' => $villain->avatar],200);
    }

    public function destroy($id)
    {
        Villain::destroy($id);
        return response()->json(['status'=>'success'],200);
    }
}
