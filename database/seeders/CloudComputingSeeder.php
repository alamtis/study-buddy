<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class CloudComputingSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            [
                'question' => 'What is cloud computing?',
                'answers' => [
                    'Computing using rainwater',
                    'Delivering computing services over the internet',
                    'A new type of computer',
                    'A weather forecasting technology'
                ],
                'correct_answer' => 1, // 'Delivering computing services over the internet'
            ],
            [
                'question' => 'What is the difference between IaaS, PaaS, and SaaS?',
                'answers' => [
                    'Different cloud storage providers',
                    'Infrastructure, Platform, and Software as a Service',
                    'Types of cloud security',
                    'Cloud pricing models'
                ],
                'correct_answer' => 1, // 'Infrastructure, Platform, and Software as a Service'
            ],
            [
                'question' => 'What is auto-scaling in cloud computing?',
                'answers' => [
                    'Automatic updates of cloud software',
                    'Dynamically adjusting resources based on demand',
                    'Scaling images in cloud storage',
                    'Automatically reducing costs'
                ],
                'correct_answer' => 1, // 'Dynamically adjusting resources based on demand'
            ],
            [
                'question' => 'What is a cloud-native application?',
                'answers' => [
                    'An application that only works on cloudy days',
                    'An application designed specifically for cloud environments',
                    'A weather app',
                    'An application that stores data in the cloud'
                ],
                'correct_answer' => 1, // 'An application designed specifically for cloud environments'
            ],
            [
                'question' => 'What is multi-cloud strategy?',
                'answers' => [
                    'Using multiple monitors',
                    'Using services from multiple cloud providers',
                    'Having multiple backups',
                    'A cloud service for multiple users'
                ],
                'correct_answer' => 1, // 'Using services from multiple cloud providers'
            ],
            // Add more questions to reach 10-15 total
        ];

        foreach ($questions as $questionData) {
            Question::create([
                'field' => 'Cloud Computing',
                'question' => $questionData['question'],
                'answers' => $questionData['answers'],
                'correct_answer' => $questionData['correct_answer'],
            ]);
        }
    }
}
