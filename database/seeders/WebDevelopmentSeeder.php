<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class WebDevelopmentSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            [
                'question' => 'What is the purpose of HTML?',
                'answers' => [
                    'To style web pages', 'To structure web content', 'To handle server-side logic',
                    'To manage databases'
                ],
                'correct_answer' => 1, // 'To structure web content'
            ],
            [
                'question' => 'What does CSS stand for?',
                'answers' => [
                    'Computer Style Sheets', 'Cascading Style Sheets', 'Creative Style Sheets', 'Colorful Style Sheets'
                ],
                'correct_answer' => 1, // 'Cascading Style Sheets'
            ],
            [
                'question' => 'Which of the following is a JavaScript framework?',
                'answers' => ['Django', 'Ruby on Rails', 'Vue.js', 'Flask'],
                'correct_answer' => 2, // 'Vue.js'
            ],
            [
                'question' => 'What is the purpose of responsive web design?',
                'answers' => [
                    'To make websites load faster', 'To improve SEO', 'To adapt to different screen sizes',
                    'To add animations to websites'
                ],
                'correct_answer' => 2, // 'To adapt to different screen sizes'
            ],
            [
                'question' => 'What is the difference between GET and POST methods in HTTP?',
                'answers' => [
                    'GET is faster, POST is slower', 'GET sends data in the URL, POST sends data in the request body',
                    'GET is more secure than POST', 'POST can only send text data, GET can send any type of data'
                ],
                'correct_answer' => 1, // 'GET sends data in the URL, POST sends data in the request body'
            ],
            // Add more questions to reach 10-15 total
        ];

        foreach ($questions as $questionData) {
            Question::create([
                'field' => 'Web Development',
                'question' => $questionData['question'],
                'answers' => $questionData['answers'],
                'correct_answer' => $questionData['correct_answer'],
            ]);
        }
    }
}
