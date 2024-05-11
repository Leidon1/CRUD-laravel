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

            $defaultMalePhoto = 'storage/profile-photos/default/male.png';
            $defaultFemalePhoto = 'storage/profile-photos/default/female.png';
            $defaultNonBinaryPhoto = 'storage/profile-photos/default/unisex.png';

            // Validate the incoming request data
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'gender' => ['required', 'string', Rule::in(['male', 'female', 'non-binary'])],
                'country' => ['required', 'string', Rule::in(config('global.countries'))],
                'birthday' => ['required', 'date'],
                'role' => ['required', 'integer', Rule::in([2, 1, 0])],
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

            // Set default profile photo based on gender if no photo provided
            if (!$request->has('profile_photo')) {
                switch ($validatedData['gender']) {
                    case 'male':
                        $validatedData['profile_photo'] = $defaultMalePhoto;
                        break;
                    case 'female':
                        $validatedData['profile_photo'] = $defaultFemalePhoto;
                        break;
                    case 'non-binary':
                        $validatedData['profile_photo'] = $defaultNonBinaryPhoto;
                        break;
                    default:
                        $validatedData['profile_photo'] = 'storage/profile-photos/default/user.png';
                }
            }

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
