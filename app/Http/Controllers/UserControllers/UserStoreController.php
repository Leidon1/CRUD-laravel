<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;


class UserStoreController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return View
     */


    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'gender' => ['required', 'string', Rule::in(['male', 'female', 'non-binary'])],
                'country' => ['required', 'string', Rule::in(config('global.countries'))],
                'profile_photo' => 'https://media.licdn.com/dms/image/C4E0BAQGiEj7SiyhMUA/company-logo_200_200/0/1668178088214/we_web_developers_logo?e=2147483647&v=beta&t=PPaEYSJkqAzTxGeMaBM_7OvyNYTYYNWiQZW85vLvDZ8',
                'birthday' => ['required', 'date'],
                'role' => ['required', 'string', Rule::in(['admin', 'user', 'guest'])],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            // Create a new user record
            $user = User::create([
                'name' => $validatedData['name'],
                'last_name' => $validatedData['last_name'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'gender' => $validatedData['gender'],
                'country' => $validatedData['country'],
                'birthday' => $validatedData['birthday'],
                'role' => $validatedData['role'],
                'password' => Hash::make($validatedData['password']),
            ]);

            // Log successful user creation
            Log::info('User created successfully', ['user_id' => $user->id]);

            // Return a success response
            return response()->json([
                'success' => true,
                'user' => $user // Include the user data in the response
            ]);
        } catch (ValidationException $e) {
            // Log validation errors
            Log::error('Validation error during user creation', ['errors' => $e->errors()]);

            // Return validation errors to the client
            return response()->json(['success' => false, 'errors' => $e->errors()]);
        } catch (\Exception $e) {
            // Log other errors
            Log::error("User creation error: " . $e->getMessage());

            // Return a generic error message to the client
            return response()->json(['success' => false, 'error' => 'User creation failed. Please try again.'], 500);
        }
    }
}
