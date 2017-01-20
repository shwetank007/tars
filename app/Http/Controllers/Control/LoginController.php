<?php

namespace App\Http\Controllers\Control;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function index() {
        if(Auth::guard('user')->check()) {
            return Redirect::route("dashboard");
        }
        return view('login');
    }

   public function login(Request $request) {
   		$email 		= $request->get('email');
   		$password 	= $request->get('password');

   		$credentials = ['email' => $email,'password' => $password];

   		if(Auth::guard('user')->attempt($credentials)) {
   			return response(['status'=>'success']);
   		}

   		return response(['status' => 'fail']);
   }

   public function logout() {
       if (Auth::guard('user')->check()) {
           Auth::guard('user')->logout();
           return response(['status'=>'success']);
       }
       return response(['status' => 'fail']);
   }
}
