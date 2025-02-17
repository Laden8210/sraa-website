<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Utils\AccommodationManager;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function showUsers(Request $request) {
        $query = User::where('is_deleted', false);

        $billetingQuarters = new AccommodationManager();
        $quarters = $billetingQuarters->getQuarters();
    
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('mobile_num', 'like', '%' . $request->search . '%');
            });
        }
    
        // Filter by billeting_quarter
        if ($request->has('billeting_quarter') && $request->billeting_quarter != '') {
            $query->where('billeting_quarter', $request->billeting_quarter);
        }
    
        $users = $query->paginate(10); 
    
        return view('user.users', compact('users', 'quarters'));
    }
    
    public function createUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile_num' => 'required|string|max:255|unique:users,mobile_num',
            'billeting_quarter' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
    
        User::create([
            'name' => $request->name,
            'mobile_num' => $request->mobile_num,
            'billeting_quarter' => $request->billeting_quarter,
            'password' => bcrypt($request->password),
            'is_deleted' => false,
        ]);
    
        return response()->json(['success' => true]);
    }

    public function updateUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile_num' => 'required|string|max:255|unique:users,mobile_num,' . $request->user_id . ',user_id',
            'billeting_quarter' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
    
        $user = User::find($request->user_id);
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }
    
        $user->name = $request->name;
        $user->mobile_num = $request->mobile_num;
        $user->billeting_quarter = $request->billeting_quarter;
        $user->save();
    
        return response()->json(['success' => true]);
    }
    
    
}
