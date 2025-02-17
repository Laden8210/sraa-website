<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function recordAttendance(Request $request){

        $attendanceData = $request->input('attendance');
        
        // Here you would typically save the attendance data to the database
        // For example:
        // Attendance::create($attendanceData);

        return response()->json([
            'status' => 'success',
            'message' => 'Attendance recorded successfully',
            'data' => $attendanceData
        ]);
    }
    public function login(Request $request){
        return json_encode([
            'status' => 'success',
            'message' => 'Attendance fetched successfully',
            'data' => [
                'faculty' => [
                    'user_id' => 'John Doe',
                    'name' => 'Present'
                ],

            ]
        ]);
    }
}
