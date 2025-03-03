<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Utils\AccommodationManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceController extends Controller
{
    private $increase_student;
    private $increase_coach;
    private $total_student;
    private $total_coach;

    public function show(Request $request)
    {
        if (Auth::user()->role == "superintendent") {
            $query = Attendance::whereHas('participant', function ($q) {
                $q->where('division', Auth::user()->division);
            })->with(["participant", "user"]);
            $this->getTotalAttendance(Auth::user()->division);
        } else {
            $query = Attendance::with(["participant", "user"]);
            $this->getTotalAttendance($request->division);
        }

        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';

            $query->whereHas('participant', function ($q) use ($searchTerm) {
                $q->where('participants.name', 'like', $searchTerm);
            })->orWhereHas('user', function ($q) use ($searchTerm) {
                $q->where('users.name', 'like', $searchTerm);
            });
        }

        if ($request->has('division') && $request->division != '') {
            $query->whereHas('participant', function ($q) use ($request) {
                $q->where('division', $request->division);
            });
        }
        if ($request->has('role') && $request->role != '') {
            $query->whereHas('participant', function ($q) use ($request) {
                $q->where('participant_role', $request->role);
            });
        }

        if ($request->has('date') && $request->date != '') {
            [$startDate, $endDate] = explode(' - ', urldecode(urldecode($request->date)));
            $startDate = Carbon::createFromFormat('m/d/Y', trim($startDate))->startOfDay();
            $endDate = Carbon::createFromFormat('m/d/Y', trim($endDate))->endOfDay();
            $query->whereBetween('date_recorded', [$startDate, $endDate]);
        }

        $manager = new AccommodationManager();
        $divisions = $manager->getDivisions();

        $attendance = $query->paginate(10);

        

        $increase_coach = $this->increase_coach;
        $increase_student = $this->increase_student;
        $total_coach = $this->total_coach;
        $total_student = $this->total_student;

        return view('user.attendance', compact('attendance', 'divisions', 'increase_coach', 'increase_student', 'total_coach', 'total_student'));
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
    public function getAttendanceData(Request $request)
    {
        $date = $request->query('date', Carbon::today()->toDateString()); // Get date from request or default to today

        if (Auth::user()->role == "superintendent") {
            $query = Attendance::whereDate('created_at', $date)
                ->with('participant')
                ->whereHas('participant', function ($q) use ($request) {
                    $q->where('division', Auth::user()->division);
                })
                ->selectRaw('HOUR(time_recorded) as hour, COUNT(*) as count')
                ->groupBy('hour')
                ->orderBy('hour');
        } else {
            $query = Attendance::whereDate('created_at', $date)
                ->with('participant')
                ->selectRaw('HOUR(time_recorded) as hour, COUNT(*) as count')
                ->groupBy('hour')
                ->orderBy('hour');
        }




        if ($request->has('division') && $request->division != '') {
            $query->whereHas('participant', function ($q) use ($request) {
                $q->where('division', $request->division);
            });
        }

        $attendanceData = $query->pluck('count', 'hour');

        $formattedData = array_fill(0, 24, 0);
        foreach ($attendanceData as $hour => $count) {
            $formattedData[$hour] = $count;
        }

        return response()->json([
            'categories' => array_map(fn($h) => sprintf("%02d:00", $h), range(0, 23)), // ["00:00", "01:00", ..., "23:00"]
            'data' => $formattedData
        ]);
    }

    public function getAttendanceRangeData(Request $request)
    {
        $endDate = Carbon::createFromFormat('m/d/Y', $request->query('end_date', Carbon::today()->format('m/d/Y')))->endOfDay();
        $startDate = Carbon::createFromFormat('m/d/Y', $request->query('start_date', Carbon::parse($endDate)->subDays(10)->format('m/d/Y')))->startOfDay();
    
        if (Auth::user()->role == "superintendent") {
            $query = Attendance::whereBetween('created_at', [$startDate, $endDate])
                ->with('participant')
                ->whereHas('participant', function ($q) {
                    $q->where('division', Auth::user()->division);
                })
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date');
        } else {
            $query = Attendance::whereBetween('created_at', [$startDate, $endDate])
                ->with('participant')
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date');
        }
    
        if ($request->has('division') && $request->division != '') {
            $query->whereHas('participant', function ($q) use ($request) {
                $q->where('division', $request->division);
            });
        }
    
        $attendanceData = $query->pluck('count', 'date');
    
        $allDates = [];
        $current = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
    
        while ($current <= $end) {
            $formattedDate = $current->format('Y-m-d');
            $allDates[$formattedDate] = $attendanceData[$formattedDate] ?? 0;
            $current->addDay();
        }
    
        return response()->json([
            'categories' => array_keys($allDates),
            'data' => array_values($allDates)
        ]);
    }

    public function generateAttendancereport(Request $request)
    {
        $startDate = "";
        $endDate = "";

        if (Auth::user()->role == "superintendent") {
            $query = Attendance::whereHas('participant', function ($q) {
                $q->where('division', Auth::user()->division);
            })->with(["participant", "user"]);
        } else {
            $query = Attendance::with(["participant", "user"]);
        }

        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';

            $query->whereHas('participant', function ($q) use ($searchTerm) {
                $q->where('participants.name', 'like', $searchTerm);
            })->orWhereHas('user', function ($q) use ($searchTerm) {
                $q->where('users.name', 'like', $searchTerm);
            });
        }

        if ($request->has('division') && $request->division != '') {
            $query->whereHas('participant', function ($q) use ($request) {
                $q->where('division', $request->division);
            });
        }
        if ($request->has('role') && $request->role != '') {
            $query->whereHas('participant', function ($q) use ($request) {
                $q->where('participant_role', $request->role);
            });
        }

        if ($request->has('date') && $request->date != '') {
            [$startDate, $endDate] = explode(' - ', urldecode(urldecode($request->date)));
            $startDate = Carbon::createFromFormat('m/d/Y', trim($startDate))->startOfDay()->format('Y-m-d');
            $endDate = Carbon::createFromFormat('m/d/Y', trim($endDate))->endOfDay()->format('Y-m-d');
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $division = $request->division;
        $role = $request->role;

        $attendances = $query->get();
        $pdf = Pdf::loadView('user.attendance_report_pdf', compact('attendances', 'startDate', 'endDate', 'division', 'role'));

        return $pdf->stream('attendance_report.pdf');
    }
}
