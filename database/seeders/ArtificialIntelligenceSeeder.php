<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class ArtificialIntelligenceSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            [
                'question' => 'What is machine learning?',
                'answers' => [
                    'Teaching machines to read',
                    'A subset of AI that allows systems to learn from data',
                    'Programming robots',
                    'A type of computer memory'
                ],
                'correct_answer' => 1, // 'A subset of AI that allows systems to learn from data'
            ],
            [
                'question' => 'What is the difference between supervised and unsupervised learning?',
                'answers' => [
                    'Supervised uses labeled data, unsupervised uses unlabeled data',
                    'Supervised is faster, unsupervised is slower',
                    'Supervised is for images, unsupervised is for text',
                    'Supervised requires more data, unsupervised requires less'
                ],
                'correct_answer' => 0, // 'Supervised uses labeled data, unsupervised uses unlabeled data'
            ],
            [
                'question' => 'What is deep learning?',
                'answers' => [
                    'Learning about the deep sea',
                    'A subset of machine learning using neural networks with multiple layers',
                    'A type of data storage',
                    'Learning that takes a long time'
                ],
                'correct_answer' => 1, // 'A subset of machine learning using neural networks with multiple layers'
            ],
            [
                'question' => 'What is natural language processing (NLP)?',
                'answers' => [
                    'Teaching computers to understand human languages',
                    'A programming language',
                    'Processing natural resources',
                    'A type of speech therapy'
                ],
                'correct_answer' => 0, // 'Teaching computers to understand human languages'
            ],
            [
                'question' => 'What is a neural network in AI?',
                'answers' => [
                    'A network of computers',
                    'A model inspired by the human brain',
                    'A type of internet connection',
                    'A database of neurons'
                ],
                'correct_answer' => 1, // 'A model inspired by the human brain'
            ],
            // Add more questions to reach 10-15 total
        ];

        foreach ($questions as $questionData) {
            Question::create([
                'field' => 'Artificial Intelligence',
                'question' => $questionData['question'],
                'answers' => $questionData['answers'],
                'correct_answer' => $questionData['correct_answer'],
            ]);
        }
    }
}
