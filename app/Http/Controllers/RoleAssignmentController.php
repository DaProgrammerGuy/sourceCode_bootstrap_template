<?php

namespace App\Http\Controllers;

use App\Events\AssignRole;
use App\Models\User;
use Illuminate\Http\Request;

class RoleAssignmentController extends Controller
{
    //
    public function create()
    {
        return view('assign-role');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:admin,user,teacher',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->syncRoles($request->role);

        event(new AssignRole($user->name, $request->role));

        return response()->json([
            'status' => 'success',
            'message' => "{$user->name} is now {$request->role}",
        ]);
    }
}
