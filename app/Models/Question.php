<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'quiz_name',
        'correct_answer', // Add this field to store the correct answer
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
