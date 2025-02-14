<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function fetchAttendance(Request $request){
        return json_encode([
            'status' => 'success',
            'message' => 'Attendance fetched successfully',
            'data' => [
                'faculty' => [
                    'name' => 'John Doe',
                    'attendance' => 'Present'
                ],

            ]
        ]);
    }
}
