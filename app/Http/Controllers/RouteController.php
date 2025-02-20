<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Utils\AccommodationManager;
use Illuminate\Http\Request;

class RouteController extends Controller
{

    public function index(){
        return view('welcome');
    }
    public function login(){
        return view('login');
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

    public function user(){
        return view('user.users');
    }

    public function attendance(){
        return view('user.attendance');
    }

    public function register(){
        $manager = new AccommodationManager();
        $divisions = $manager->getDivisions();
        $events = $manager->getEvents();

        return view('registration', compact('divisions', 'events'));
    }

}
