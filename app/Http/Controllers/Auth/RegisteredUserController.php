<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return View
     */
    public function create(): View
    {
        $countries = config('global.countries');
        return view('auth.register', compact('countries'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate($this->validator());
        \Log::debug('Request data:', $request->all());

        try {
            $user = User::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'username' => $this->generateUsername($request->name, $request->last_name),
                'email' => $request->email,
                'gender' => $request->gender,
                'country' => $request->country,
                'birthday' => $request->birthday,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            \Log::error("Registration error: " . $e->getMessage());
            return back()->withErrors(['error' => 'Registration failed. Please try again.']);
        }
    }

    private function generateUsername(string $name, string $lastname): string
    {
        $baseUsername = strtolower($name . $lastname[0]); // Lowercase for consistency
        $counter = 1;
        $finalUsername = $baseUsername;

        while (User::where('username', $finalUsername)->exists()) {
            $finalUsername = $baseUsername . $counter;
            $counter++;
        }

        return $finalUsername;
    }

    /**
     * Get the validation rules that apply to the registration request.
     *
     * @return array
     */
    protected function validator()
    {
        $messages = [
            'name.required' => 'The first name field is required.',
            'name.string' => 'The first name must be a string.',
            'name.max' => 'The first name may not be longer than 255 characters.',
            'last_name.required' => 'The last name field is required.',
            'last_name.string' => 'The last name must be a string.',
            'last_name.max' => 'The last name may not be longer than 255 characters.',
            'email.required' => 'The email address is required.',
            'email.string' => 'The email must be a string.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be longer than 255 characters.',
            'email.unique' => 'This email is already registered.',
            'gender.required' => 'Please select a gender.',
            'gender.in' => 'Selected gender is invalid.',
            'country.required' => 'Country selection is required.',
            'country.string' => 'Country must be a valid string.',
            'country.in' => 'Selected country is invalid.',
            'birthday.required' => 'The birthday is required.',
            'birthday.date' => 'The birthday is not a valid date.',
            'birthday.before' => 'You must be at least 18 years old.',
            'birthday.after' => 'Invalid birthday date, too far in the past.',
            'password.required' => 'A password is required.',
            'password.string' => 'The password must be a string.',
            'password.confirmed' => 'Passwords do not match.',
        ];

        return [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'gender' => ['required', 'in:male,female,non-binary'],
            'country' => ['required', 'string', 'in:' . implode(',', Config::get('global.countries'))],
            'birthday' => ['required', 'date', 'before:' . Carbon::now()->subYears(18)->toDateString(), 'after:' . Carbon::now()->subYears(100)->toDateString()],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ], $messages;
}

    /**
     * Check if username is available.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkUsername(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);
        return response()->json($this->generateUsername($data['name'], $data['last_name']));
    }
}

