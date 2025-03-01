<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventResult;
use App\Utils\AccommodationManager;

class ResultController extends Controller
{
    public function showEventResults()
    {
        $manager = new AccommodationManager();
        $events = $manager->getEvents();

        $eventResults = [];
        foreach ($events as $event) {
            $results = EventResult::where('event_name', $event)->get();
            $eventResults[] = [
                'event_name' => $event,
                'results' => $results,
            ];
        }

        $divisions = $manager->getDivisions();
        return view('user.event-results', compact('eventResults', 'divisions'));
    }

    public function getMedalTally()
    {
        $manager = new AccommodationManager();
        $allDivisions = $manager->getDivisions();

        $filteredDivisions = array_filter($allDivisions, function($division) {
            return $division !== 'Main HQ';
        });

        $medalTally = [];
        foreach ($filteredDivisions as $division) {
            $goldCount = EventResult::where('division', $division)->where('medal_type', 'Gold')->count();
            $silverCount = EventResult::where('division', $division)->where('medal_type', 'Silver')->count();
            $bronzeCount = EventResult::where('division', $division)->where('medal_type', 'Bronze')->count();
            $totalCount = $goldCount + $silverCount + $bronzeCount;

            $medalTally[] = [
                'division' => $division,
                'gold' => $goldCount,
                'silver' => $silverCount,
                'bronze' => $bronzeCount,
                'total' => $totalCount,
            ];
        }

        usort($medalTally, function ($a, $b) {
            if ($a['gold'] == $b['gold']) {
                if ($a['silver'] == $b['silver']) {
                    return $b['bronze'] - $a['bronze'];
                }
                return $b['silver'] - $a['silver'];
            }
            return $b['gold'] - $a['gold'];
        });

        foreach ($medalTally as $index => $tally) {
            $medalTally[$index]['rank'] = $index + 1;
        }
        // return($medalTally);
        return view('welcome', compact('medalTally'));
    }

    public function updateEventResult(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'gold_winner' => 'required|string|max:255',
            'gold_division' => 'required|string|max:255',
            'silver_winner' => 'required|string|max:255',
            'silver_division' => 'required|string|max:255',
            'bronze_winner' => 'required|string|max:255',
            'bronze_division' => 'required|string|max:255',
        ]);

        $medals = [
            'Gold' => ['winner' => $request->gold_winner, 'division' => $request->gold_division],
            'Silver' => ['winner' => $request->silver_winner, 'division' => $request->silver_division],
            'Bronze' => ['winner' => $request->bronze_winner, 'division' => $request->bronze_division],
        ];

        foreach ($medals as $medalType => $data) {
            EventResult::updateOrInsert(
                [
                    'event_name' => $request->event_name,
                    'medal_type' => $medalType,
                ],
                [
                    'winner_name' => $data['winner'],
                    'division' => $data['division'],
                    'updated_at' => now(),
                ]
            );
        }

        return response()->json(['success' => true]);
    }
}
