<?php

namespace App\Http\Controllers\UserControllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class UserGenerateUniqueUsernameController extends Controller
{
public function __invoke(Request $request)
{
$name = $request->input('name');
$last_name = $request->input('last_name');

$username = $this->generateUsername($name, $last_name);

return response()->json(['username' => $username]);
}

private function generateUsername(string $name, string $last_name): string
{
$username = strtolower($name . $last_name[0]);
$finalUsername = $username;
$user = User::query()->where('username', $username)->first();
$nr = 0;

while ($user) {
$nr++;
$finalUsername = $username . $nr;
$user = User::query()->where('username', $finalUsername)->first();
}

Log::debug('Suggested username:', ['username' => $finalUsername]);

return $finalUsername;
}
}
