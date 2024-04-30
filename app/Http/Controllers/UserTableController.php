<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class UserTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function userData(Request $request)
    {
        $users = User::all();

        // Check if it's an AJAX request
        if ($request->ajax()) {
            // Modify timestamps for presentation
            foreach ($users as $user) {
                $user->birthday_formatted = Carbon::parse($user->birthday)->format('Y-m-d');
                $user->created_at_formatted = Carbon::parse($user->created_at)->format('Y-m-d H:i:s');
                $user->last_login_formatted = Carbon::parse($user->last_login)->format('Y-m-d H:i:s');
                // Add more fields as needed
            }

            return response()->json(['data' => $users]);
        } else {
            // If it's not an AJAX request, return the view
            return view('users.table', ['users' => $users]);
        }
    }
}
