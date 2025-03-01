<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coach;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Utils\AccommodationManager;
use App\Models\Participant;
use Illuminate\Support\Facades\Hash;

class CoachController extends Controller
{
    public function show(Request $request) {
        $query = Participant::where('is_deleted', false)->where('participant_role', 'coach');

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

        $coaches = $query->paginate(10);

        $manager = new AccommodationManager();
        $divisions = $manager->getDivisions();
        $events = $manager->getEvents();

        return view('user.faculty', compact('coaches', 'divisions', 'events'));
    }

    public function store(Request $request) {
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
            'participant_role' => 'coach',
            'password' => Hash::make("!".$username),
            'is_deleted' => false,
        ]);

        return response()->json(['success' => true]);
    }


    public function getParticipantEvent($event) {
        $manager = new AccommodationManager();
        $events = $manager->getEvents();

        $event = strtolower(preg_replace('/\s+/', '', $event));
        foreach ($events as $e) {
            if (strtolower(preg_replace('/\s+/', '', $e)) == $event) {
                return $e;
            }
        }
        return null;
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'event' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $coach = Participant::find($request->participant_id);

        if (!$coach) {
            return response()->json(['success' => false, 'message' => 'Coach not found'], 404);
        }

        $coach->name = $request->name;
        $coach->division = $request->division;
        $coach->school = $request->school;
        $coach->event = $request->event;
        $coach->save();

        return response()->json(['success' => true]);
    }
    

    private function generateUniqueUsername($name)
    {
        $baseUsername = strtolower(preg_replace('/\s+/', '', $name));
        $username = $baseUsername;
        $counter = 1;

        while (Participant::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
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

            $manager = new AccommodationManager();
            $events = $manager->getEvents();
            $eventNames = array_map(function($event) {
                return strtolower(preg_replace('/\s+/', '', $event));
            }, $events);

            $coaches = [];
            $totalRows = iterator_count($worksheet->getRowIterator()) - 1;
            $batchSize = ceil($totalRows / 2); 
            
            foreach ($worksheet->getRowIterator(2) as $row) { 
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); 

                $data = [];
                foreach ($cellIterator as $cell) {
                    $data[] = $cell->getValue(); 
                }

                if (empty($data[1])) {
                    return response()->json(['success' => false, 'message' => "Event is missing for participant '{$data[0]}' in row {$row->getRowIndex()}."], 422);
                }

                $eventName = strtolower(preg_replace('/\s+/', '', $data[1] ?? ''));
                if (!in_array($eventName, $eventNames)) {
                    return response()->json(['success' => false, 'message' =>  "Event '{$data[1]}' does not exist for participant '{$data[0]}' in row {$row->getRowIndex()}."], 422);
                }
            }
            

            foreach ($worksheet->getRowIterator(2) as $row) { 
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); 

                $data = [];
                foreach ($cellIterator as $cell) {
                    $data[] = $cell->getValue(); 
                }

                $username = $this->generateUniqueUsername($data[0]);
                $event = $this->getParticipantEvent($data[1]);

                $coaches[] = [
                    'name' => $data[0] ?? null,
                    'username' => $username,
                    'school' => $data[2] ?? null,
                    'division' => $request->division,
                    'event' => $event,
                    'participant_role' => 'coach',
                    'password' => Hash::make("!".$username), 
                    'is_deleted' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if (count($coaches) >= $batchSize) {
                    Participant::insert($coaches);
                    $coaches = [];
                }
            }

            if (!empty($coaches)) {
                Participant::insert($coaches);
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}