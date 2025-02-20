<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Utils\AccommodationManager;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use ZipArchive;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function show(Request $request)
    {
        $query = Participant::where('is_deleted', false)->where('participant_role', 'student');

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('username', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('division') && $request->division != '') {
            $query->where('division', $request->division);
        }

        if ($request->has('event') && $request->event != '') {
            $query->where('event', $request->event);
        }

        $students = $query->paginate(10);

        $manager = new AccommodationManager();
        $divisions = $manager->getDivisions();
        $events = $manager->getEvents();

        return view('user.student', compact('students', 'divisions', 'events'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'event' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $username = $this->generateUniqueUsername($request->name);

        Participant::create([
            'name' => $request->name,
            'username' => $username,
            'division' => $request->division,
            'school' => $request->school,
            'event' => $request->event,
            'participant_role' => 'student',
            'password' => Hash::make("!".$username),
            'is_deleted' => false,
        ]);

        return response()->json(['success' => true]);
    }

    private function generateUniqueUsername($name)
    {
        $baseUsername = strtolower(preg_replace('/\s+/', '', $name));
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'event' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $student = Participant::find($request->student_id);

        if (!$student) {
            return response()->json(['success' => false, 'message' => 'Student not found'], 404);
        }

        $student->name = $request->name;
        $student->division = $request->division;
        $student->school = $request->school;
        $student->event = $request->event;
        $student->save();

        return response()->json(['success' => true]);
    }


    public function createFromExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,csv|max:2048',
            'division' => 'required|string|max:255',
            'event' => 'required|string|max:255',
        ]);

        try {
            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();

            $batchSize = 100; 
            $batchData = [];

            foreach ($worksheet->getRowIterator(2) as $row) { 
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); 

                $data = [];
                foreach ($cellIterator as $cell) {
                    $data[] = $cell->getValue(); 
                }
                $username = $this->generateUniqueUsername($data[0]); 
                
                $name = $data[0] ?? null;

                $batchData[] = [
                    'name' => $name,
                    'username' => $username,
                    'division' => $request->division, 
                    'school' => $data[1] ?? null,
                    'event' => $request->event,
                    'participant_role' => 'student',
                    'password' => Hash::make("!".$username), 
                    'is_deleted' => false,
                ];

                if (count($batchData) >= $batchSize) {
                    Participant::insert($batchData); 
                    $batchData = []; 
                }
            }

            if (!empty($batchData)) {
                Participant::insert($batchData);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function generatePassword($name)
    {
        $initials = '';
        if ($name) {
            $nameParts = explode(' ', $name);
            foreach ($nameParts as $part) {
                $initials .= strtoupper($part[0]);
            }
        }
        return $initials;
    }
}
