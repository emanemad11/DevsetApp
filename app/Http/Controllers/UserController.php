<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function saveProfile(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'first_name'      => 'nullable|string|max:255',   // First name (optional, string, max 255 characters)
            'last_name'       => 'nullable|string|max:255',   // Last name (optional, string, max 255 characters)
            'email'           => 'required|email|unique:users,email,' . auth()->user()->id, // Email (required, unique except for the current user)
            'password'        => 'nullable|string|min:6|confirmed',  // Password (optional, must be confirmed if provided)
            'whatsapp_number' => 'nullable|string|unique:users,whatsapp_number,' . auth()->user()->id, // WhatsApp number (unique except for the current user)
            'linkedin'        => 'nullable|url',    // LinkedIn URL (optional, must be a valid URL)
            'github'          => 'nullable|url',    // GitHub URL (optional, must be a valid URL)
            'behance'         => 'nullable|url',    // Behance URL (optional, must be a valid URL)
            'birthdate'       => 'nullable|date',   // Birthdate (optional, must be a valid date)
            'specialization'  => 'nullable|string|max:255', // Specialization (optional, string, max 255 characters)
            'cv'              => 'nullable|file',   // CV (optional, must be a file if provided)
            'college'         => 'nullable|string|max:255',  // College name (optional, string, max 255 characters)
            'university'      => 'nullable|string|max:255',  // University name (optional, string, max 255 characters)
            'level'           => 'nullable|string|max:255',  // Education level (optional, string, max 255 characters)
        ]);

        // Get the currently authenticated user
        $user = auth()->user();

        // Update the user's data in the users table or keep existing values if not provided
        $user->update([
            'first_name'      => $request->first_name ?? $user->first_name,  // Update first name or keep existing
            'last_name'       => $request->last_name ?? $user->last_name,    // Update last name or keep existing
            'email'           => $request->email ?? $user->email,            // Update email or keep existing
            'password'        => $request->password ?? $user->password,      // Update password or keep existing
            'whatsapp_number' => $request->whatsapp_number ?? $user->whatsapp_number, // Update WhatsApp number or keep existing
            'linkedin'        => $request->linkedin ?? $user->linkedin,      // Update LinkedIn URL or keep existing
            'github'          => $request->github ?? $user->github,          // Update GitHub URL or keep existing
            'behance'         => $request->behance ?? $user->behance,        // Update Behance URL or keep existing
            'birthdate'       => $request->birthdate ?? $user->birthdate,    // Update birthdate or keep existing
            'specialization'  => $request->specialization ?? $user->specialization, // Update specialization or keep existing
            'cv'              => $request->hasFile('cv') ? $request->file('cv')->store('cvs') : $user->cv, // If CV file is provided, store it, otherwise keep existing
            'college'         => $request->college ?? $user->college,        // Update college or keep existing
            'university'      => $request->university ?? $user->university,  // Update university or keep existing
            'level'           => $request->level ?? $user->level,            // Update education level or keep existing
        ]);

        // Return a success message and the updated user data
        return response()->json([
            'message' => 'Profile saved successfully!',  // Success message
            'user'    => $user,  // Return the updated user data
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
