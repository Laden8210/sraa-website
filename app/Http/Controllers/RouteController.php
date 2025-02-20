<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Utils\AccommodationManager;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Participant;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RouteController extends Controller
{
    private $total_attendance;
    private $total_student;
    private $total_coach;

    public function index()
    {
        return view('welcome');
    }
    public function login()
    {
        if (Auth::user() != null) {
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    
    public function dashboard(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            $query = Attendance::with(["participant", "user"]);

            if ($request->has('date') && $request->date != '') {
                $query->where('date_recorded', $request->date);
            }

            if ($request->has('division') && $request->division != '') {
                $query->whereHas('participant', function ($q) use ($request) {
                    $q->where('division', $request->division);
                });
            }

            $manager = new AccommodationManager();
            $divisions = $manager->getDivisions();

            $attendance = $query->paginate(10);

            $this->getTotalAttendance($request->division);

            $total_attendance = $this->total_attendance;
            $total_student = $this->total_student;
            $total_coach = $this->total_coach;
            return view('user.dashboard', compact('attendance', 'divisions', 'total_attendance', 'total_student', 'total_coach'));

        } else if (Auth::user()->role = "superintendent") {
            $query = Attendance::with(["participant", "user"])
                ->whereHas('participant', function ($q) {
                    $q->where('division', Auth::user()->division);
                });


            if ($request->has('date') && $request->date != '') {
                $query->where('date_recorded', $request->date);
            }

            

            $manager = new AccommodationManager();
            $divisions = $manager->getDivisions();

            $attendance = $query->paginate(10);

            $this->getTotalAttendance($request->division);

            $total_attendance = $this->total_attendance;
            $total_student = $this->total_student;
            $total_coach = $this->total_coach;

            return view('user.dashboard_superintendent', compact('attendance', 'divisions', 'total_attendance', 'total_student', 'total_coach'));
        }
    }

    public function getTotalAttendance($division)
    {
        if (Auth::user()->role == 'admin') {
            $attendance_count = Attendance::with(["participant", "user"]);

            if (!empty($division)) {
                $attendance_count->whereHas('participant', function ($q) use ($division) {
                    $q->where('division', $division);
                });
            }
    
            $attendance_count = $attendance_count->count();

        } else if(Auth::user()->role == 'superintendent') {
            $attendance_count = Attendance::with(["participant", "user"])
                ->whereHas('participant', function ($q) {
                    $q->where('division', Auth::user()->division);
                })
                ->count();
        }

        $total_student = Participant::where('participant_role', 'student')->count();
        $total_coach = Participant::where('participant_role', 'faculty')->count();

        $this->total_attendance = $attendance_count;
        $this->total_student = $total_student;
        $this->total_coach = $total_coach;
    }

    public function qrCode()
    {
        return view('user.qr-code');
    }

    public function faculty()
    {
        return view('user.faculty');
    }

    public function student()
    {
        return view('user.student');
    }

    public function user()
    {
        return view('user.users');
    }

    public function attendance()
    {
        return view('user.attendance');
    }

    public function register()
    {
        $manager = new AccommodationManager();
        $divisions = $manager->getDivisions();
        $events = $manager->getEvents();

        return view('registration', compact('divisions', 'events'));
    }
}
