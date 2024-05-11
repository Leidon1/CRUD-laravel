<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
/**
* Display the login view.
*/
public function create(): View
{
return view('auth.login');
}

/**
* Handle an incoming authentication request.
*/
public function store(Request $request)
{
$input = $request->all();

// Validation rules
$rules = [
'email' => 'required|email',
'password' => 'required',
];

// Validate the request data
$validator = Validator::make($input, $rules);

// Check if validation fails
if ($validator->fails()) {
return redirect()->route('login')->withErrors($validator)->withInput();
}

// Attempt to authenticate the user
if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
// Authentication successful
// Redirect based on user role
if (Auth::user()->role == 0) {
return redirect()->route('dashboard');
} elseif (Auth::user()->role == 1) {
return redirect()->route('moderatorDashboard');
} elseif (Auth::user()->role == 2) {
return redirect()->route('adminDashboard');
}
} else {
// Authentication failed
return redirect()->route('login')->with('error', "Wrong credentials");
}
}

/**
* Destroy an authenticated session.
*/
public function destroy(Request $request): RedirectResponse
{
Auth::guard('web')->logout();

$request->session()->invalidate();

$request->session()->regenerateToken();

return redirect('/');
}
}
