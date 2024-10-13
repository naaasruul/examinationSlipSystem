<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function showLogin(){
        return view('login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'ic'=>'required',
            'password'=>'required'
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            $user = Auth::user();   

            if($user->role == 2){
                return redirect('adminMain');
            }elseif($user->role == 1){
                return redirect('studentMain');
            }else{
                return redirect('teacherMain');

            }
        }

        return back()->withErrors(['email'=>'credentials not in database']);
    }

    public function logout(Request $request){
        $request->session()->regenerate();
        $request->session()->invalidate();
        return redirect('');
    }
}
