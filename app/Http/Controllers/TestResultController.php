<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestResultController extends Controller
{
    public function index()
    {
        $results = TestResult::where('user_id', Auth::id())->get();
        return response()->json($results);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'answers' => 'required|array',
        ]);

        // Initialize score variable
        $score = 0;

        // Calculate points based on answers
        foreach ($request->answers as $answer) {
            if ($answer == 'true') {
                $score++; // Add a point for each 'true' answer
            }
        }

        // Store the result in the database with user_id
        $testResult = TestResult::create([
            'user_id' => Auth::id(), // Save the authenticated user's ID
            'score' => $score,
        ]);

        // Return a response
        return response()->json(['message' => 'Test result stored successfully', 'score' => $testResult->score]);
    }
}
