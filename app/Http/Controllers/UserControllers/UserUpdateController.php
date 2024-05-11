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

class UserUpdateController extends Controller
{


    /**
     * Update the specified user.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function fetch($id)
    {
        // Fetch user data by ID
        $user = User::find($id);

        // Return user data as JSON response
        return response()->json(['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        Log::info('User ID for update: ' . $id);

        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($id)],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
                'gender' => ['required', 'string', Rule::in(['male', 'female', 'non-binary'])],
                'country' => ['required', 'string', Rule::in(config('global.countries'))],
                'birthday' => ['required', 'date'],
                'role' => ['required', 'integer', Rule::in([2, 1, 0])],
                'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            ]);


            // Find the user by ID
            $user = User::find($id);


            // Update user data
            $user->update([
                'name' => $validatedData['name'],
                'last_name' => $validatedData['last_name'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'gender' => $validatedData['gender'],
                'country' => $validatedData['country'],
                'birthday' => $validatedData['birthday'],
                'role' => $validatedData['role'],
            ]);

            // Update password if provided
            if (!empty($validatedData['password'])) {
                $user->update([
                    'password' => Hash::make($validatedData['password']),
                ]);
            }

            // Log successful user update
            Log::info('User updated successfully', ['user_id' => $user->id]);

            // Return a success response
            return response()->json([
                'success' => true,
                'user' => $user // Include the updated user data in the response
            ]);
        } catch (ValidationException $e) {
            // Log validation errors
            Log::error('Validation error during user update', ['errors' => $e->errors()]);

            // Return validation errors to the client
            return response()->json(['success' => false, 'errors' => $e->errors()]);
        } catch (\Exception $e) {
            // Log other errors
            Log::error("User update error: " . $e->getMessage());

            // Return a generic error message to the client
            return response()->json(['success' => false, 'error' => 'User update failed. Please try again.'], 500);
        }
    }
}
