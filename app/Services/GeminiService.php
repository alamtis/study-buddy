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
            return $question['question'].': '.$question['answers'][$answer];
        }, $questions, $answers);

        $prompt = "Based on the following user answers from {$user->name} in the {$field} field, analyze the weaknesses in their knowledge: ".implode("\n",
                $userResponses);
        $result = $this->client->geminiPro()->generateContent($prompt);
        return $result->text();
    }

    public function generateStudyPlan($user, $report, $field)
    {
        $prompt = "Create a study plan with necessary materials for {$user->name} in the {$field} field, based on this weakness report: ".$report;
        $result = $this->client->geminiPro()->generateContent($prompt);
        return $result->text();
    }
}
