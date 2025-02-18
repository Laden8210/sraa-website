<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Utils\AccommodationManager;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function showUsers(Request $request)
    {
        $query = User::where('is_deleted', false);

        $billetingQuarters = new AccommodationManager();
        $quarters = $billetingQuarters->getQuarters();

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('username', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by billeting_quarter
        if ($request->has('billeting_quarter') && $request->billeting_quarter != '') {
            $query->where('billeting_quarter', $request->billeting_quarter);
        }

        if ($request->has('division') && $request->division != '') {
            $query->where('division', $request->division);
        }

        $manager = new AccommodationManager();
        $divisions = $manager->getDivisions();

        $users = $query->paginate(10);

        return view('user.users', compact('users', 'quarters', 'divisions'));
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'billeting_quarter' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'role' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $username = $this->generateUniqueUsername($request->name, $request->division);

        User::create([
            'name' => $request->name,
            'username' => $username,
            'billeting_quarter' => $request->billeting_quarter,
            'password' => bcrypt($request->password),
            'division' => $request->division,
            'role' => $request->role,
            'is_deleted' => false,
        ]);

        return response()->json(['success' => true]);
    }
    private function generateUniqueUsername($name, $division)
    {
        $baseUsername = strtolower(preg_replace('/\s+/', '', $name)) . '_' . strtolower(str_replace(' ', '', $division));
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }

    public function updateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'billeting_quarter' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'role' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $user->name = $request->name;
        $user->billeting_quarter = $request->billeting_quarter;
        $user->division = $request->division;
        $user->role = $request->role;
        $user->save();

        return response()->json(['success' => true]);
    }
}
