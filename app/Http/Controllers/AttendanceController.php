<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Utils\AccommodationManager;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function show(Request $request)
    {
        $query = Attendance::with(["participant", "user"]);

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

        $manager = new AccommodationManager();
        $divisions = $manager->getDivisions();

        $attendance = $query->paginate(10);

        return view('user.attendance', compact('attendance', 'divisions'));
    }
    public function getAttendanceData(Request $request)
    {
        $date = $request->query('date', Carbon::today()->toDateString()); // Get date from request or default to today

        $query = Attendance::whereDate('created_at', $date)
            ->with('participant')
            ->selectRaw('HOUR(time_recorded) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->orderBy('hour');
    
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
}
