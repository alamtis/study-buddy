<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Question;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EvaluationController extends Controller
{
    protected GeminiService $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function index()
    {
        $fields = [
            'Web Development', 'Database Management', 'Network Security', 'Cloud Computing', 'Artificial Intelligence'
        ];

        return Inertia::render('FieldSelection', [
            'fields' => $fields
        ]);
    }

    public function start(Request $request)
    {
        $request->validate([
            'selectedField' => 'required|string'
        ]);

        $field = $request->input('selectedField');
        $questions = Question::where('field', $field)->inRandomOrder()->take(15)->get();

        $evaluation = Evaluation::create([
            'user_id' => auth()->id(),
            'field' => $field,
        ]);

        session(['evaluation_id' => $evaluation->id, 'questions' => $questions, 'currentQuestionIndex' => 0]);

        return Inertia::render('Evaluation', [
            'questions' => $questions,
            'currentQuestionIndex' => 0,
        ]);
    }

    public function answer(Request $request)
    {
        $request->validate([
            'selectedAnswer' => 'required|integer'
        ]);

        $evaluationId = session('evaluation_id');
        $questions = session('questions');
        $currentQuestionIndex = session('currentQuestionIndex', 0);

        // Save the answer
        $evaluation = Evaluation::findOrFail($evaluationId);
        $user = $evaluation->user;
        $evaluation->questions()->attach($questions[$currentQuestionIndex]->id, [
            'selected_answer' => $request->input('selectedAnswer'),
        ]);

        $currentQuestionIndex++;

        if ($currentQuestionIndex >= count($questions)) {
            // Evaluation complete
            $questionsWithAnswers = $evaluation->questions()->withPivot('selected_answer', 'correct_answer')->get();

            $correctAnswers = $questionsWithAnswers->pluck('correct_answer')->toArray();
            $selectedAnswers = $questionsWithAnswers->pluck('pivot.selected_answer')->toArray();

            $allCorrect = array_map(
                fn($correct, $selected) => $correct === $selected,
                $correctAnswers,
                $selectedAnswers
            );

            $allCorrect = array_reduce($allCorrect, fn($carry, $value) => $carry && $value, true);

            if ($allCorrect) {
                // User answered all questions correctly
                $congratsMessage = "Congratulations, {$user->name}! You've answered all questions correctly.";

                // Generate study plan with field information only
                $studyPlan = $this->geminiService->generateStudyPlan($user, $evaluation->field);

                // Save study plan to evaluation
                $evaluation->update([
                    'congratulations_message' => $congratsMessage,
                    'study_plan' => $studyPlan,
                ]);

                return redirect()->route('report.show', $evaluationId);
            }

            // If not all correct, generate detailed report for incorrect answers
            $incorrectQuestions = $questionsWithAnswers->filter(function ($question) {
                return $question->pivot->selected_answer !== $question->correct_answer;
            });

            $report = $this->geminiService->generateReport($user, $incorrectQuestions->toArray(), $selectedAnswers,
                $evaluation->field);
            $studyPlan = $this->geminiService->generateStudyPlan($user, $report, $evaluation->field);

            // Save report and study plan to evaluation
            $evaluation->update([
                'report' => $report,
                'study_plan' => $studyPlan,
            ]);

            return redirect()->route('report.show', $evaluationId);
        }

        session(['currentQuestionIndex' => $currentQuestionIndex]);

        return Inertia::render('Evaluation', [
            'questions' => $questions,
            'currentQuestionIndex' => $currentQuestionIndex,
        ]);
    }


}
