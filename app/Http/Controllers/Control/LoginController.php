<?php

namespace App\Http\Controllers\Control;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        return view('login');
    }

   public function login(Request $request) {
   		$email 		= $request->get('email');
   		$password 	= $request->get('password');

   		$credentials = ['email' => $email,'password' => $password];

   		if(Auth::guard('user')->attempt($credentials)) {
   			return response()->json(['status'=>'success'],200);
   		}
   		return response()->json(['status'=>'fail'],400);
   }

   public function logout() {
       Auth::guard('user')->logout();
//       return Redirect::route(l;
   }
}
