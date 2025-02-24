<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Utils\AccommodationManager;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Participant;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class RouteController extends Controller
{
    private $total_attendance;
    private $total_student;
    private $total_coach;
    private $increase_attendance;
    private $increase_student;
    private $increase_coach;

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

            $date = $request->has('date') && $request->date != '' ? $request->date : now()->toDateString();
            $query->where('date_recorded', $date);

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

            $increase_attendance = $this->increase_attendance;
            $increase_student = $this->increase_student;  
            $increase_coach = $this->increase_coach;

            return view('user.dashboard', compact('attendance', 'divisions', 'total_attendance', 'total_student', 'total_coach', 'increase_attendance', 'increase_student', 'increase_coach'));
        } else if (Auth::user()->role == "superintendent") {
            $query = Attendance::with(["participant", "user"])
                ->whereHas('participant', function ($q) {
                    $q->where('division', Auth::user()->division);
                });

            $date = $request->has('date') && $request->date != '' ? $request->date : now()->toDateString();
            $query->where('date_recorded', $date);

            $manager = new AccommodationManager();
            $divisions = $manager->getDivisions();

            $attendance = $query->paginate(10);

            $this->getTotalAttendance($request->division);

            $total_attendance = $this->total_attendance;
            $total_student = $this->total_student;
            $total_coach = $this->total_coach;

            $increase_attendance = $this->increase_attendance;
            $increase_student = $this->increase_student;  
            $increase_coach = $this->increase_coach;

            return view('user.dashboard_superintendent', compact('attendance', 'divisions', 'total_attendance', 'total_student', 'total_coach', 'increase_attendance', 'increase_student', 'increase_coach'));
        }
    }


    public function getTotalAttendance($division)
    {
        if (Auth::user()->role == 'admin') {
            $attendance_count = Attendance::with(["participant", "user"])
                ->whereDate('created_at', Carbon::today());

            if (!empty($division)) {
                $attendance_count->whereHas('participant', function ($q) use ($division) {
                    $q->where('division', $division);
                });
            }

            $this->total_attendance = $attendance_count->count();
            $this->total_student = Attendance::whereHas('participant', function ($q) {
                $q->where('participant_role', 'student');
            })
                ->whereDate('created_at', Carbon::today())
                ->count();

            $this->total_coach = Attendance::whereHas('participant', function ($q) {
                $q->where('participant_role', 'coach');
            })
                ->whereDate('created_at', Carbon::today())
                ->count();

            $yesterday_total = Attendance::whereDate('created_at', Carbon::yesterday())->count();
            $yesterday_student = Attendance::whereHas('participant', function ($q) {
                $q->where('participant_role', 'student');
            })->whereDate('created_at', Carbon::yesterday())->count();

            $yesterday_coach = Attendance::whereHas('participant', function ($q) {
                $q->where('participant_role', 'coach');
            })->whereDate('created_at', Carbon::yesterday())->count();
        } else if (Auth::user()->role == 'superintendent') {

            $this->total_attendance = Attendance::with(["participant", "user"])
                ->whereHas('participant', function ($q) {
                    $q->where('division', Auth::user()->division);
                })
                ->whereDate('created_at', Carbon::today())
                ->count();

            $this->total_student = Attendance::whereHas('participant', function ($q) {
                $q->where('participant_role', 'student')
                    ->where('division', Auth::user()->division);
            })
                ->whereDate('created_at', Carbon::today())
                ->count();

            $this->total_coach = Attendance::whereHas('participant', function ($q) {
                $q->where('participant_role', 'coach')
                    ->where('division', Auth::user()->division);
            })
                ->whereDate('created_at', Carbon::today())
                ->count();

            $yesterday_total = Attendance::whereHas('participant', function ($q) {
                $q->where('division', Auth::user()->division);
            })->whereDate('created_at', Carbon::yesterday())->count();

            $yesterday_student = Attendance::whereHas('participant', function ($q) {
                $q->where('participant_role', 'student')
                    ->where('division', Auth::user()->division);
            })->whereDate('created_at', Carbon::yesterday())->count();

            $yesterday_coach = Attendance::whereHas('participant', function ($q) {
                $q->where('participant_role', 'coach')
                    ->where('division', Auth::user()->division);
            })->whereDate('created_at', Carbon::yesterday())->count();
        }

        $this->increase_attendance = $this->calculatePercentageIncrease($this->total_attendance, $yesterday_total);
        $this->increase_student = $this->calculatePercentageIncrease($this->total_student, $yesterday_student);
        $this->increase_coach = $this->calculatePercentageIncrease($this->total_coach, $yesterday_coach);
    }

    private function calculatePercentageIncrease($today, $yesterday)
    {
        if ($yesterday == 0) {
            return $today > 0 ? 100 : 0;
        }
        return (($today - $yesterday) / $yesterday) * 100;
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
