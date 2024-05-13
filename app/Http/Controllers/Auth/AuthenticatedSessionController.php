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
            // Debug: Output the user's role

            $role = Auth::user()->role;

            // Redirect based on user role
            if ($role == 0) {
                return redirect()->route('userDashboard');
            } elseif ($role == 1) {
                return redirect()->route('moderatorDashboard');
            } elseif ($role == 2) {
                return redirect()->route('adminDashboard');
            } else {
                // Fallback redirection
                return redirect()->route('dashboard'); // Or any other default route
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
