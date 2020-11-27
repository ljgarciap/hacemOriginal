<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('auth.login');
    }

    public function login(Request $request){
        $this->validate($request,[
            'email'=>'required|string',
            'password'=>'required|string'
        ]);

        Log::info('Showing user profile for user: '.$request);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'estado'=>1])){
            return redirect()->route('principal');
        }
        else{
            return back()->withErrors(['email'=>trans('auth.failed')])
            ->withInput(request(['email']));
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/login');
    }

}
