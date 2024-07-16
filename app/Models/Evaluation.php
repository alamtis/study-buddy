<?php

// app/Models/Evaluation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'field', 'report', 'study_plan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'user_answers')
            ->withPivot('selected_answer')
            ->withTimestamps();
    }

    public function flashcards()
    {
        return $this->hasMany(Flashcard::class);
    }
}
