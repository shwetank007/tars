<?php

namespace App\Http\Controllers\Control;

use App\Http\Controllers\Controller;
use App\Power;
use Illuminate\Http\Request;

class PowerController extends Controller
{
    public function destroy ($id)
    {
        Power::destroy($id);
        return response()->json(['status'=>'success'],200);
    }
}
