<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'question_id' => 'required|exists:questions,id', // Ensure question exists
            'answer'      => 'required|boolean', // Ensure answer is boolean
        ]);

        // Get the authenticated user's ID
        $userId = Auth::id();

        // Create a new answer record in the database
        Answer::create([
            'question_id' => $request->question_id, // Set question ID
            'user_id'     => $userId, // Set user ID
            'answer'      => $request->answer, // Set the user's answer
        ]);

        // Return a success response
        return response()->json(['message' => 'Answer saved successfully.']);
    }

    public function getQuizAnswers(Request $request)
    {
        // Validate the incoming request to ensure 'quiz_name' is provided
        $request->validate([
            'quiz_name' => 'required|string',
        ]);

        // Get the authenticated user's ID
        $userId = Auth::id();

        // Retrieve questions related to the specified quiz name
        $questions = Question::where('quiz_name', $request->quiz_name)->with('answers')->get();

        $results = [];

        // Loop through each question to get the latest answer
        foreach ($questions as $question) {
            // Get the latest answer for the current question by the authenticated user
            $latestAnswer = $question->answers()
                ->where('user_id', $userId)
                ->latest() // Get the latest answer
                ->first();

            $results[] = [
                'question' => $question->question,
                'correct_answer' => $question->correct_answer,
                'user_answer' => $latestAnswer ? $latestAnswer->answer : null,
                'is_correct' => $latestAnswer && $latestAnswer->answer === $question->correct_answer,
                'latest_answer_id' => $latestAnswer ? $latestAnswer->id : null, // Optional: Include answer ID for reference
                'created_at' => $latestAnswer ? $latestAnswer->created_at : null, // Optional: Include timestamp of answer
            ];
        }

        // Return the results as JSON
        return response()->json($results);
    }

    public function getQuizResults(Request $request)
    {
        // Validate the incoming request to ensure 'quiz_name' is provided
        $request->validate([
            'quiz_name' => 'required|string',
        ]);

        // Get the authenticated user's ID
        $userId = Auth::id();

        // Retrieve questions related to the specified quiz name
        $questions = Question::where('quiz_name', $request->quiz_name)->with('answers')->get();

        // Initialize counters for correct and incorrect answers
        $correctCount = 0;
        $incorrectCount = 0;

        // Loop through each question to get the latest answer
        foreach ($questions as $question) {
            // Get the latest answer for the current question by the authenticated user
            $latestAnswer = $question->answers()
                ->where('user_id', $userId)
                ->latest() // Get the latest answer
                ->first();

            // Check if the latest answer is correct
            if ($latestAnswer) {
                if ($latestAnswer->answer === $question->correct_answer) {
                    $correctCount++;
                } else {
                    $incorrectCount++;
                }
            }
        }

        // Calculate total questions in the quiz
        $totalQuestions = $questions->count();

        // Return the results as JSON
        return response()->json([
            'correct'         => $correctCount,
            'incorrect'       => $incorrectCount,
            'total_questions' => $totalQuestions, // Number of questions in the quiz
        ]);
    }
}
