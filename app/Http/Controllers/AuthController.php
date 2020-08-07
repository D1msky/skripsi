<?php
namespace App\Http\Controllers;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function postlogin(Request $request){
        if(Auth::attempt(['id_user' => $request->ID_USER,'password' => $request->PASSWORD])){
            return redirect('/');
        }else{
            return redirect('/login')->with('gagal','ID/Password Salah !');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
