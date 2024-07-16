<?php

namespace App\Services;

use Gemini;

class GeminiService
{
    protected $client;

    public function __construct()
    {
        $apiKey = getenv('GEMINI_API_KEY');
        $this->client = Gemini::client($apiKey);
    }

    public function generateReport($user, $questions, $answers, $field)
    {
        $userResponses = array_map(function ($question, $answer) {
            if (!is_array($question) || !isset($question['question']) || !isset($question['answers'])) {
                return "Invalid question format";
            }
            if (!isset($question['answers'][$answer])) {
                return $question['question'].': Invalid answer';
            }
            return $question['question'].': '.$question['answers'][$answer];
        }, $questions, $answers);

        $prompt = "Based on the incorrect answers from {$user->name} in the {$field} field, provide a brief analysis of their weaknesses: ".implode("\n",
                $userResponses);
        $result = $this->client->geminiPro()->generateContent($prompt);
        return $result->text();
    }

    public function generateStudyPlan($user, $report, $field)
    {
        $prompt = "Create a targeted study plan focusing on the areas where {$user->name} showed weaknesses in the {$field} field. Use the following report for reference: ".$report;
        $result = $this->client->geminiPro()->generateContent($prompt);
        return $result->text();
    }

    public function generateFlashcards($user, $report, $field)
    {
        $prompt = "Based on the weaknesses identified in this report for {$user->name} in the {$field} field, create a set of 10 flashcards. Each flashcard should include a question, the correct answer, and 3-4 multiple-choice options. Provide the flashcards in the following format:\n\n**Question:** [Question]\n**Answer:** [Correct Answer]\n**Options:** [Option1, Option2, Option3, Option4]\n\nHere is the report: {$report}";
        $result = $this->client->geminiPro()->generateContent($prompt);
        return $this->parseFlashcards($result->text());
    }

    private function parseFlashcards(string $text)
    {
        $lines = explode("\n", trim($text));
        $flashcards = [];
        $currentCard = [];

        foreach ($lines as $line) {
            if (preg_match('/^\*\*Question:\*\* (.+)/', $line, $matches)) {
                if (!empty($currentCard)) {
                    $flashcards[] = $currentCard;
                    $currentCard = [];
                }
                $currentCard['question'] = trim($matches[1]);
            } elseif (preg_match('/^\*\*Answer:\*\* (.+)/', $line, $matches)) {
                $currentCard['answer'] = trim($matches[1]);
            } elseif (preg_match('/^\*\*Options:\*\* (.+)/', $line, $matches)) {
                $currentCard['options'] = array_map('trim', explode(',', $matches[1]));
            }
        }

        if (!empty($currentCard)) {
            $flashcards[] = $currentCard;
        }

        return $flashcards;
    }


}


