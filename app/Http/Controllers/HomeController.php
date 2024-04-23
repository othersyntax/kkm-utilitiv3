<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        if(Auth::id()){
            $role = Auth()->user()->role;
            // dd($role);
            if($role=='Pengguna'){
                return redirect('dashboard');
            }
            else if($role=='Pentadbir'){
                return view('pentadbir.index');
            }
            else{
                return redirect()->back();
            }
        }
    }

    public function logout(){
        // dd("IM HERE");
        Auth::logout();
        return redirect()->route('login');
    }
}
