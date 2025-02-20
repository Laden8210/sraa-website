<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Attendance;

class APIController extends Controller
{
    public function recordAttendances(Request $request)
    {
        try {
            $request->validate([
                'attendances' => 'required|array',
                'attendances.*.participant_id' => 'required|string',
                'attendances.*.time_recorded' => 'required|string',
                'attendances.*.date_recorded' => 'required|string',
                'attendances.*.reference_number' => 'required|string',
                'attendances.*.user_id' => 'required|integer'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        }

        $attendanceData = $request->input('attendances');
        $savedAttendances = [];
        $duplicateAttendances = [];

        foreach ($attendanceData as $data) {

            $data['time_recorded'] = date('H:i:s', strtotime($data['time_recorded']));
            $data['date_recorded'] = date('Y-m-d', strtotime($data['date_recorded']));

            $existingAttendance = Attendance::where('reference_number', $data['reference_number'])->first();

            if (!$existingAttendance) {
                $attendance = Attendance::create([
                    'participant_id' => $data['participant_id'],
                    'time_recorded' => $data['time_recorded'],
                    'date_recorded' => $data['date_recorded'],
                    'reference_number' => $data['reference_number'],
                    'type' => 'in',
                    'user_id' => $data['user_id']
                ]);
                $savedAttendances[] = $attendance;
            } else {
                $duplicateAttendances[] = $data;
            }
        }


        if (count($savedAttendances) > 0 && count($duplicateAttendances) > 0) {
            $message = 'Attendance processing completed with some duplicates';
        } elseif (count($savedAttendances) > 0) {
            $message = 'Attendance processing completed';
        } else {
            $message = 'No attendance processed';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'saved_attendances' => $savedAttendances,
            'duplicates' => $duplicateAttendances
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
                'message' => collect($e->errors())->flatten()->first(),
                'data' => []
            ], 422);
        }
        $username = $request->input('username');
        $password = $request->input('password');


        $user = User::where('username', $username)->first();


        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
                'data' => []
            ], 200);
        }

        if (!Hash::check($password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid password',
                'data' => []
            ], 200);
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [$user]
            ]
        );

    }

    public function getTotalByBilleting(Request $request) {
        try {
            $request->validate([
                'billeting_quarter' => 'required|string'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        }

        $billeting_quarter = $request->input('billeting_quarter');

        $total = User::where('billeting_quarter', $billeting_quarter)->count();

        return response()->json([
            'status' => 'success',
            'message' => 'Total users retrieved successfully',
            'data' => ['total' => $total]
        ]);
    }


    public function retrieveUser(Request $request){
// hello
        try{

            $request->validate([
                'user_id' => 'required|integer'
            ]);

            $user_id = $request->input('user_id');

            $user = User::find($user_id);

            if(!$user){
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 200);
            }

        }catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User details retrieved successfully',
            'data' => $user
        ]);
    }
}
