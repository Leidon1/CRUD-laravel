<?php

namespace App\Http\Controllers\UserControllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class UserCheckUsernameController extends Controller
{
public function __invoke(Request $request)
{
$data = $request->validate([
'name' => 'required|string|max:255',
'last_name' => 'required|string|max:255',
'username' => 'required|string|max:255', // Add validation for username
]);

$username = $data['username'];

// Check if the provided username is available
$userWithProvidedUsername = User::query()->where('username', $username)->first();
$available = !$userWithProvidedUsername;

if (!$available) {
// If the username is not available, return it as an error
return response()->json(['error' => 'This username is taken'], 422);
}

return response()->json(['message' => 'This username is available.']);
}
}
