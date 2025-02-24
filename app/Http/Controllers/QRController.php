<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Utils\AccommodationManager;
use App\Models\Coach;
use Illuminate\Support\Facades\DB;
use App\Models\Participant;
use App\Utils\EncryptionHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class QRController extends Controller
{
    public function show(Request $request)
    {
        if(Auth::user()->role == "superintendent") {
            $query = Participant::where('is_deleted', false)->where('division', Auth::user()->division);
        } else {
            $query = Participant::where('is_deleted', false);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('username', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('division') && $request->division != '') {
            $query->where('division', $request->division);
        }

        if ($request->has('role') && $request->role != '') {
            $query->where('participant_role', $request->role);
        }

        if ($request->has('event') && $request->event != '') {
            $query->where('event', $request->event);
        }

        $results = $query->paginate(10);

        $manager = new AccommodationManager();
        $divisions = $manager->getDivisions();
        $events = $manager->getEvents();

        $results->getCollection()->transform(function ($participant) {
            $participant->qr_data = EncryptionHelper::encrypt(json_encode([
                'name' => $participant->name,
                'participant_role' => $participant->participant_role,
                'division' => $participant->division,
                'school' => $participant->school,
                'event' => $participant->event,
                'participant_id' => $participant->participant_id,
            ]));
            return $participant;
        });

        return view('user.qr-code', compact('results', 'divisions', 'events'));
    }

    public function generateQrCode(Request $request)
    {
        $query = Participant::where('is_deleted', false);

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('username', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('division') && $request->division != '') {
            $query->where('division', $request->division);
        }

        if ($request->has('role') && $request->role != '') {
            $query->where('participant_role', $request->role);
        }

        $participants = $query->get();

        if ($participants->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'Participant not found']);
        }
        $participants->each(function ($participant) {
            $participant->qr_data = EncryptionHelper::encrypt(json_encode([
                'name' => $participant->name,
                'participant_role' => $participant->participant_role,
                'division' => $participant->division,
                'school' => $participant->school,
                'event' => $participant->event,
                'participant_id' => $participant->participant_id,
            ]));
            return $participant;
        });
        $division = $request->division;
        $role = $request->role;

        // $pdf = Pdf::loadView('user.generate-qr-code', compact('participants'));

        // return $pdf->download('SRAA_MEET_2025_Participants.pdf');

        return view('user.generate-qr-code', compact('participants', 'division', 'role'));
    }
    public function generateQrID(Request $request)
    {
        $query = Participant::where('is_deleted', false);

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('username', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('division') && $request->division != '') {
            $query->where('division', $request->division);
        }

        if ($request->has('role') && $request->role != '') {
            $query->where('participant_role', $request->role);
        }

        $participants = $query->get();

        if ($participants->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'Participant not found']);
        }
        $participants->each(function ($participant) {
            $participant->qr_data = EncryptionHelper::encrypt(json_encode([
                'name' => $participant->name,
                'participant_role' => $participant->participant_role,
                'division' => $participant->division,
                'school' => $participant->school,
                'event' => $participant->event,
                'participant_id' => $participant->participant_id,
            ]));
            return $participant;
        });

       

        // $pdf = Pdf::loadView('user.generate-qr-code', compact('participants'));

        // return $pdf->download('SRAA_MEET_2025_Participants.pdf');

        return view('user.generate-qr-id', compact('participants'));
    }
    public function generateSingleQrCode(Request $request)
    {
        $query = Participant::where('is_deleted', false)->where('participant_id', $request->participant_id);

        $participants = $query->get();

        if (!$participants) {
            return redirect()->back()->withErrors(['error' => 'Participant not found']);
        }

        $participants->getCollection()->transform(function ($participant) {
            $participant->qr_data = 'id = ' . $participant->participant_id . "\n" . 'name = ' . $participant->name;
            return $participant;
        });

        // $pdf = Pdf::loadView('user.generate-qr-code', compact('participants'));

        // return $pdf->download('SRAA_MEET_2025_Participants.pdf');

        return view('user.generate-qr-id', compact('participants',));
    }
}
