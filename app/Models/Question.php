<?php

// app/Models/Question.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['field', 'question', 'answers', 'correct_answer'];

    protected $casts = [
        'answers' => 'array',
    ];

    public function evaluations()
    {
        return $this->belongsToMany(Evaluation::class, 'user_answers')
            ->withPivot('selected_answer');
    }
}
