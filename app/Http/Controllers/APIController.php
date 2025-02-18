<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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

        try {
            $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        }

        $username = $request->input('username');
        $password = $request->input('password');

        // return response()->json([
        //     'status' => 'success',
        //     'message' => $username,
        //     'data' => [
        //         [
        //             'user_id' => $username,
        //             'name' => 'Present'
        //         ],
        //     ]
        // ]);

        return response()->json([
            'status' => 'Hello',

        ], 401);
    }
}
