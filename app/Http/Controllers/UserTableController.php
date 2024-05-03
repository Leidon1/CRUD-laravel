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
    public function index()
    {
        // Fetch users using Eloquent ORM
        $users = User::all();

        // Return the view with users data
        return view('users.table')->with('users', $users);
    }
}
