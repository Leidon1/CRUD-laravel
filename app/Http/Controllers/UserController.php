<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
public function index()
{
$users = User::all();
return view('users.index', compact('users'));
}

public function create()
{
return view('users.create');
}

public function store(Request $request)
{
// Validate input
$request->validate([
// Add validation rules here
]);

// Create new user
User::create($request->all());

return redirect()->route('users.index')->with('success', 'User created successfully.');
}

public function edit($id)
{
$user = User::find($id);
return view('users.edit', compact('user'));
}

public function update(Request $request, $id)
{
// Validate input
$request->validate([
// Add validation rules here
]);

// Update user
$user = User::find($id);
$user->update($request->all());

return redirect()->route('users.index')->with('success', 'User updated successfully.');
}

public function destroy($id)
{
// Delete user
User::find($id)->delete();

return redirect()->route('users.index')->with('success', 'User deleted successfully.');
}
}
