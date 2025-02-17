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

class StudentController extends Controller
{
    public function show(Request $request) {
        $query = Participant::where('is_deleted', false)->where('participant_role', 'student');

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('mobile_num', 'like', '%' . $request->search . '%');
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

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile_num' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'event' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        Participant::create([
            'name' => $request->name,
            'mobile_num' => $request->mobile_num,
            'division' => $request->division,
            'school' => $request->school,
            'event' => $request->event,
            'participant_role' => 'student',
            'password' => bcrypt($request->password),
            'is_deleted' => false,
        ]);

        return response()->json(['success' => true]);
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile_num' => 'required|string|max:255|unique:participants,mobile_num,' . $request->participant_id . ',participant_id',
            'division' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'event' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $student = Participant::find($request->participant_id);

        if (!$student) {
            return response()->json(['success' => false, 'message' => 'Student not found'], 404);
        }

        $student->name = $request->name;
        $student->mobile_num = $request->mobile_num;
        $student->division = $request->division;
        $student->school = $request->school;
        $student->event = $request->event;
        $student->save();

        return response()->json(['success' => true]);
    }

    
    
    public function createFromExcel(Request $request) {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,csv|max:2048',
            'division' => 'required|string|max:255',
            'event' => 'required|string|max:255',
        ]);

        try {
            // Load the uploaded file
            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();

            $batchSize = 100; // Number of records to process at a time
            $batchData = [];

            foreach ($worksheet->getRowIterator(2) as $row) { // Start from row 2 (skip header)
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // Iterate through empty cells

                $data = [];
                foreach ($cellIterator as $cell) {
                    $data[] = $cell->getValue(); // Get cell value
                }

                // Assuming the Excel structure is: Name | Mobile Number | School | Event
                $name = $data[0] ?? null;
                $password = $this->generatePassword($name);

                $batchData[] = [
                    'name' => $name,
                    'mobile_num' => $data[1] ?? null,
                    'division' => $request->division, // Add the division from request
                    'school' => $data[2] ?? null,
                    'event' => $request->event,
                    'participant_role' => 'student',
                    'password' => bcrypt($password), // Set the generated password
                    'is_deleted' => false,
                ];

                if (count($batchData) >= $batchSize) {
                    Participant::insert($batchData); // Insert batch data
                    $batchData = []; // Reset batch data
                }
            }

            // Insert remaining data
            if (!empty($batchData)) {
                Participant::insert($batchData);
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function generatePassword($name) {
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
