<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'first_name'    => 'nullable|string|max:255',  // First name (optional, string, max 255 characters)
            'last_name'     => 'nullable|string|max:255',  // Last name (optional, string, max 255 characters)
            'linkedin'      => 'nullable|url',             // LinkedIn URL (optional, must be a valid URL)
            'github'        => 'nullable|url',             // GitHub URL (optional, must be a valid URL)
            'behance'       => 'nullable|url',             // Behance URL (optional, must be a valid URL)
            'birthdate'     => 'nullable|date',            // Birthdate (optional, must be a valid date)
            'specialization' => 'nullable|string|max:255',  // Specialization (optional, string, max 255 characters)
            'cv'            => 'nullable|file',            // CV (optional, must be a file if provided)
            'college'       => 'nullable|string|max:255',  // College name (optional, string, max 255 characters)
            'university'    => 'nullable|string|max:255',  // University name (optional, string, max 255 characters)
            'level'         => 'nullable|string|max:255',  // Education level (optional, string, max 255 characters)
            'account_type'  => 'nullable|in:user,company', // Account type (optional, can be either 'user' or 'company')
        ]);

        // Get the currently authenticated user
        $user = auth()->user();

        // Update the user's profile with the provided data
        $user->update([
            'first_name'    => $request->first_name ?? $user->first_name,   // Use the provided first name or keep the current one
            'last_name'     => $request->last_name ?? $user->last_name,     // Use the provided last name or keep the current one
            'linkedin'      => $request->linkedin ?? $user->linkedin,       // Use the provided LinkedIn URL or keep the current one
            'github'        => $request->github ?? $user->github,           // Use the provided GitHub URL or keep the current one
            'behance'       => $request->behance ?? $user->behance,         // Use the provided Behance URL or keep the current one
            'birthdate'     => $request->birthdate ?? $user->birthdate,     // Use the provided birthdate or keep the current one
            'specialization' => $request->specialization ?? $user->specialization,  // Use the provided specialization or keep the current one
            'cv'            => $request->hasFile('cv') ? $request->file('cv')->store('cvs') : $user->cv,  // If a CV file is provided, store it, otherwise keep the current one
            'college'       => $request->college ?? $user->college,         // Use the provided college name or keep the current one
            'university'    => $request->university ?? $user->university,   // Use the provided university name or keep the current one
            'level'         => $request->level ?? $user->level,             // Use the provided education level or keep the current one
            'account_type'  => $request->account_type ?? $user->account_type, // Use the provided account type or keep the current one
        ]);

        // Return a response with a success message and the updated user data
        return response()->json([
            'message' => 'Profile updated successfully',  // Success message
            'user'    => $user                           // Return the updated user data
        ]);
    }

    public function showProfile()
    {
        $user = auth()->user();

        return response()->json([
            'user' => $user
        ]);
    }
}
