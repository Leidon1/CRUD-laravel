<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class \UserIndexController extends Controller
{
    public function index()
{
    $users = User::all();
    return view('users.index', compact('users'));
}
}
