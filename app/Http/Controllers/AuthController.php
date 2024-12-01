<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use Laravel\Passport\HasApiTokens;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    use HasApiTokens;

    public function login(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to log the user in
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Generate an access token for the user
        $tokenResult = $user->createToken('Access Token');
        $token = $tokenResult->accessToken;

        // Return the token and user details
        return response()->json([
            'token' => $token,
            'user'  => $user,
        ], 200);
    }

    public function register(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'first_name'   => 'required|string|max:255', // First name is required and must be a string with a maximum length of 255 characters
            'last_name'    => 'required|string|max:255', // Last name is required and must be a string with a maximum length of 255 characters
            'email'        => 'required|email|unique:users,email', // Email is required, must be valid, and should be unique in the users table
            'password'     => 'required|string|min:6|confirmed', // Password is required, must be at least 6 characters, and must be confirmed
            'account_type' => 'required|string|in:company,user', // Account type is required and must be either 'admin' or 'user'
        ]);

        // Create a new user with the validated data
        $user = User::create([
            'first_name'  => $request->first_name, // Set the user's first name
            'last_name'   => $request->last_name,  // Set the user's last name
            'email'       => $request->email,      // Set the user's email
            'password'    => Hash::make($request->password), // Hash the password before storing it in the database
            'account_type' => $request->account_type, // Set the account type (e.g., 'admin' or 'user')
        ]);

        // Create an access token for the newly created user
        $token = $user->createToken('Access Token')->accessToken;

        // Return a JSON response with the access token and user data
        return response()->json([
            'token' => $token,  // Include the access token in the response
            'user'  => $user,   // Include the user data in the response
        ], 201);  // Return HTTP status code 201 (Created)
    }

    public function forgotPassword(Request $request)
    {
        // Validate the email address in the request
        $request->validate(['email' => 'required|email']);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        // Return an error if the user is not found
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Generate a reset code (5-character random string)
        $resetCode = Str::random(5);

        // Store the reset code in the database (ensure you have a reset_code column in the users table)
        $user->reset_code = $resetCode;
        $user->save();

        // Send the reset code to the user's email
        Mail::to($user->email)->send(new ResetPasswordMail($resetCode, $user->email));

        // Return a success response
        return response()->json(['message' => 'Reset code sent.'], 200);
    }

    public function resetPassword(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'password'   => 'required|string|min:6|confirmed', // Ensure password confirmation
            'reset_code' => 'required' // Validate the reset code
        ]);

        // Check if the user exists and the reset code matches
        $user = User::where('email', $request->email)->where('reset_code', $request->reset_code)->first();

        // Return an error if the user or reset code is invalid
        if (!$user) {
            return response()->json(['message' => __('passwords.token')], 400);
        }

        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->reset_code = null; // Clear the reset code after use
        $user->save();

        // Return a success response
        return response()->json(['message' => __('passwords.reset')], 200);
    }

    public function logout(Request $request)
    {
        // Revoke the authenticated user's token
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
