<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function dashboard(){
        return view('user.dashboard');
    }

    public function qrCode(){
        return view('user.qr-code');
    }

    public function faculty(){
        return view('user.faculty');
    }

    public function student(){
        return view('user.student');
    }

    public function attendance(){
        return view('user.attendance');
    }

}
