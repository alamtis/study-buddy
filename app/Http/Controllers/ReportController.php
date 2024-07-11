<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Services\GeminiService;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function show(Evaluation $evaluation, GeminiService $geminiService)
    {
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
        } else {
            $report = $geminiService->generateReport($evaluation->user, $questions->toArray(), $answers,
                $evaluation->field);
            $studyPlan = $geminiService->generateStudyPlan($evaluation->user, $report, $evaluation->field);
        }

        $evaluation->update([
            'report' => $report,
            'study_plan' => $studyPlan,
        ]);

        return Inertia::render('Report', [
            'evaluation' => $evaluation,
            'allCorrect' => $allCorrect,
        ]);
    }
}
