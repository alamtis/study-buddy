<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Services\GeminiService;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function show(Evaluation $evaluation, GeminiService $geminiService)
    {
        // Check if the evaluation already has a report and flashcards
        if ($evaluation->study_plan) {
            // Evaluation already exists with report and flashcards
            return Inertia::render('Report', [
                'evaluation' => $evaluation->load('flashcards'),
                'allCorrect' => $evaluation->questions->every(function ($question) {
                    return $question->pivot->selected_answer === $question->correct_answer;
                }),
            ]);
        }

        // Proceed with generating report and flashcards if not already present
        $questions = $evaluation->questions()->withPivot('selected_answer')->get();
        $answers = $questions->pluck('pivot.selected_answer')->toArray();

        $allCorrect = $questions->every(function ($question) {
            return $question->pivot->selected_answer === $question->correct_answer;
        });

        if ($allCorrect) {
            $report = "Congratulations! You've answered all questions correctly.";
            $studyPlan = $geminiService->generateStudyPlan($evaluation->user,
                "{$evaluation->user} has demonstrated excellent knowledge. Provide an advanced study plan to further enhance their skills.",
                $evaluation->field);

            // No need to generate flashcards if all answers are correct
            $flashcards = [];
        } else {
            $report = $geminiService->generateReport($evaluation->user, $questions->toArray(), $answers,
                $evaluation->field);
            $studyPlan = $geminiService->generateStudyPlan($evaluation->user, $report, $evaluation->field);
            $flashcards = $geminiService->generateFlashcards($evaluation->user, $report, $evaluation->field);
        }

        // Save the report, study plan, and flashcards
        $evaluation->update([
            'report' => $report,
            'study_plan' => $studyPlan,
        ]);

        foreach ($flashcards as $card) {
            $evaluation->flashcards()->create([
                'question' => $card['question'],
                'answer' => $card['answer'],
            ]);
        }

        return Inertia::render('Report', [
            'evaluation' => $evaluation->load('flashcards'),
            'allCorrect' => $allCorrect,
        ]);
    }


}
