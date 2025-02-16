<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Utils\AccommodationManager;
use App\Models\Coach;
use Illuminate\Support\Facades\DB;
use App\Models\Participant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

class QRController extends Controller
{
    public function show(Request $request)
    {
        $query = Participant::where('is_deleted', false);

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('mobile_num', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('division') && $request->division != '') {
            $query->where('division', $request->division);
        }

        if ($request->has('role') && $request->role != '') {
            $query->where('participant_role', $request->role);
        }

        $results = $query->paginate(10);

        // Get divisions
        $manager = new AccommodationManager();
        $divisions = $manager->getDivisions();
        // return( $results);
        return view('user.qr-code', compact('results', 'divisions'));
    }
    
    public function generateQrCode(Request $request)
    {
        $query = Participant::where('is_deleted', false);

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('mobile_num', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('division') && $request->division != '') {
            $query->where('division', $request->division);
        }

        if ($request->has('role') && $request->role != '') {
            $query->where('participant_role', $request->role);
        }

        $participants = $query->get();

        if (!$participants) {
            return redirect()->back()->withErrors(['error' => 'Participant not found']);
        }

        // $pdf = Pdf::loadView('user.generate-qr-code', compact('participants'));

        // return $pdf->download('SRAA_MEET_2025_Participants.pdf');

        return view('user.generate-qr-code', compact('participants'));
    }

    public function generateSingleQrCode(Request $request)
    {
        $query = Participant::where('is_deleted', false)->where('participant_id', $request->participant_id);

        $participants = $query->get();

        if (!$participants) {
            return redirect()->back()->withErrors(['error' => 'Participant not found']);
        }

        // $pdf = Pdf::loadView('user.generate-qr-code', compact('participants'));

        // return $pdf->download('SRAA_MEET_2025_Participants.pdf');

        return view('user.generate-qr-code', compact('participants'));
    }

}
