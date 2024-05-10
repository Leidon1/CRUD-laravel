<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return View
     */
    public function create()
    {
        $countries = config('global.countries');
        return view('auth.register', compact('countries'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate($this->validator());

            // Log the request data for debugging purposes
            Log::debug('Registration request data:', $request->all());

            // Parse the birthday into the desired format
            $birthday = Carbon::createFromFormat('m/d/Y', $request->birthday)->format('Y-m-d');

            // Generate a unique username
            $username = $request->has('username') ? $request->username : $this->generateUsername($request->name, $request->last_name);


            // Create a new user record
            $user = User::create([
                'name' => $validatedData['name'],
                'last_name' => $validatedData['last_name'],
                'username' => $username,
                'email' => $validatedData['email'],
                'gender' => $validatedData['gender'],
                'profile_photo' => 'https://media.licdn.com/dms/image/C4E0BAQGiEj7SiyhMUA/company-logo_200_200/0/1668178088214/we_web_developers_logo?e=2147483647&v=beta&t=PPaEYSJkqAzTxGeMaBM_7OvyNYTYYNWiQZW85vLvDZ8',
                'country' => $validatedData['country'],
                'birthday' => $birthday,
                'role' => 0,
                'password' => Hash::make($validatedData['password']),
            ]);

            // Trigger the Registered event
            event(new Registered($user));

            // Log successful registration
            Log::info('User registered successfully', ['user_id' => $user->id]);

            // Return a success response with the generated username
            return response()->json(['success' => true, 'username' => $username]);
        } catch (ValidationException $e) {
            // Log validation errors
            Log::error('Validation error during registration', ['errors' => $e->errors()]);

            // Return validation errors to the client
            return response()->json(['success' => false, 'errors' => $e->errors()]);
        } catch (\Exception $e) {
            // Log other errors
            Log::error("Registration error: " . $e->getMessage() . "\nFile: " . $e->getFile() . "\nLine: " . $e->getLine() . "\nTrace: " . $e->getTraceAsString());

            // Return a generic error message to the client
            return response()->json([
                'success' => false,
                'error' => 'Registration failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Get the validation rules that apply to the registration request.
     *
     * @return array
     */
    protected function validator()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'gender' => ['required', 'in:male,female,non-binary'],
            'country' => ['required', 'string', 'in:' . implode(',', Config::get('global.countries'))],
            'birthday' => ['required', 'date', 'before:' . Carbon::now()->subYears(18)->toDateString(), 'after:' . Carbon::now()->subYears(100)->toDateString()],
            'password' => ['required', 'string', 'min:8', 'confirmed', Rules\Password::defaults()],
        ];
    }

    /**
     * Check if username is available.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkUsername(Request $request): JsonResponse
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


    public function generateUniqueUsername(Request $request)
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

