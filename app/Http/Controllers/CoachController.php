<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coach;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Utils\AccommodationManager;
use App\Models\Participant;

class CoachController extends Controller
{
    public function show(Request $request) {
        $query = Participant::where('is_deleted', false)->where('participant_role', 'coach');

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('mobile_num', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('division') && $request->division != '') {
            $query->where('division', $request->division);
        }

        $coaches = $query->paginate(10);

        $manager = new AccommodationManager();
        $divisions = $manager->getDivisions();

        return view('user.faculty', compact('coaches', 'divisions'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile_num' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'school' => 'required|string|max:255',
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
            'event' => 'N/A',
            'participant_role' => 'coach',
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
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $coach = Participant::find($request->participant_id);

        if (!$coach) {
            return response()->json(['success' => false, 'message' => 'Coach not found'], 404);
        }

        $coach->name = $request->name;
        $coach->mobile_num = $request->mobile_num;
        $coach->division = $request->division;
        $coach->school = $request->school;
        $coach->save();

        return response()->json(['success' => true]);
    }

    public function createFromExcel(Request $request) {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,csv|max:2048',
            'division' => 'required|string|max:255',
        ]);

        try {
            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();

            $coaches = []; // Array to store coach data
            $totalRows = iterator_count($worksheet->getRowIterator()) - 1; // Exclude header row
            $batchSize = ceil($totalRows / 2); // Batch size is half the total number of rows

            foreach ($worksheet->getRowIterator(2) as $row) { 
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); 

                $data = [];
                foreach ($cellIterator as $cell) {
                    $data[] = $cell->getValue(); 
                }

                $coaches[] = [
                    'name' => $data[0] ?? null,
                    'mobile_num' => $data[1] ?? null,
                    'school' => $data[2] ?? null,
                    'division' => $request->division,
                    'event' => 'N/A',
                    'participant_role' => 'coach',
                    'password' => bcrypt('defaultpassword'), 
                    'is_deleted' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Insert in batches of half the total number of rows to improve efficiency
                if (count($coaches) >= $batchSize) {
                    Participant::insert($coaches);
                    $coaches = [];
                }
            }

            // Insert any remaining coaches
            if (!empty($coaches)) {
                Participant::insert($coaches);
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}