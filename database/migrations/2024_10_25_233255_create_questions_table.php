<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID for the question
            $table->string('question'); // The text of the question
            $table->string('quiz_name'); // The name of the quiz the question belongs to
            $table->boolean('correct_answer')->default(true); // Default value for the correct answer
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions'); // Drop the questions table if it exists
    }
}
