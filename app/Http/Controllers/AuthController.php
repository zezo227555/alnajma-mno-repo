<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function show_login_form(){
        return view('auth.login');
    }
    public function login(Request $re){
        $re->validate([
            'username' => 'required',
            'password' => 'required'
        ],[
            'username.required' => 'مطلوب اسم المستخدم',
            'password.required' => 'مطلوب كلمة المرور'
        ]);
        $user = User::where('username', '=', $re->username)->first();
        
        if($user && Hash::check($re->password, $user->password)){
            Auth::login($user);
            session(['user_id' => $user->id, 'username' => $user->username, 'user_photo' => $user->photo]);
            return redirect()->route('home');
        }else{
            return redirect(route('auth.show.login'))->with('message', 'خطأ في اسم المستخدم او كلمة المرور')->withInput();
        }
    }

    public function logout(){
        Auth::logout();
        return redirect(route('auth.show.login'));
    }

    public function Home(){
        $username = session('username');
        $user_photo = session('user_photo');

        return view('dashboard', ['username' => $username, 'user_photo' => $user_photo]);
    }
}
