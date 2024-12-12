<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Auth;

class AuthController extends Controller{
    /** login */
    public function login(Request $request){
        return view('backend.auth.login');
    }
    /** login */

    /** sigini */
    public function singin(LoginRequest $request){
        if($request->ajax()) { return true; }

        $auth = (auth()->attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember')));

        if ($auth != false) {
            $user = auth()->user();

            if ($user->status == 'inactive') {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Account belongs to this credentials is inactive, please contact administrator');
            } elseif ($user->status == 'deleted') {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Account belongs to this credentials is deleted, please contact administrator');
            } else {
                return redirect()->route('dashboard')->with('success', 'Login successfully');
            }
        } else {
            return redirect()->route('login')->with('error', 'invalid credentials, please check credentials');
        }
    }
    /** sigini */

    /** logout */
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
    /** logout */
}
