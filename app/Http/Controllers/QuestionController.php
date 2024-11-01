<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        // Validate the quiz_name parameter
        $request->validate([
            'quiz_name' => 'required|string',
        ]);

        // Get the quiz_name from the request
        $quizName = $request->quiz_name;

        // Retrieve questions for the specified quiz
        $questions = Question::select('id', 'question')
            ->where('quiz_name', $quizName)
            ->get();

        // Check if questions exist for the given quiz_name
        if ($questions->isEmpty()) {
            return response()->json(['message' => 'No questions found for this quiz.'], 404);
        }

        // Return the questions as JSON
        return response()->json($questions);
    }
}
