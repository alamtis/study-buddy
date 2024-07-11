<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class NetworkSecuritySeeder extends Seeder
{
    public function run()
    {
        $questions = [
            [
                'question' => 'What is a firewall?',
                'answers' => [
                    'A physical wall to protect servers',
                    'A security system that monitors and controls network traffic',
                    'A type of antivirus software',
                    'A backup system for networks'
                ],
                'correct_answer' => 1, // 'A security system that monitors and controls network traffic'
            ],
            [
                'question' => 'What is encryption in network security?',
                'answers' => [
                    'Making data unreadable to unauthorized users',
                    'Compressing data for faster transmission',
                    'Deleting sensitive data',
                    'Creating multiple copies of data'
                ],
                'correct_answer' => 0, // 'Making data unreadable to unauthorized users'
            ],
            [
                'question' => 'What is a VPN?',
                'answers' => [
                    'Very Powerful Network',
                    'Virtual Private Network',
                    'Visual Processing Node',
                    'Verified Public Network'
                ],
                'correct_answer' => 1, // 'Virtual Private Network'
            ],
            [
                'question' => 'What is a DDoS attack?',
                'answers' => [
                    'Distributed Denial of Service',
                    'Data Deletion on Server',
                    'Direct Download of Software',
                    'Database Duplication on Site'
                ],
                'correct_answer' => 0, // 'Distributed Denial of Service'
            ],
            [
                'question' => 'What is two-factor authentication?',
                'answers' => [
                    'Using two different passwords',
                    'Verifying identity using two different methods',
                    'Logging in from two different devices',
                    'Having two administrators approve each login'
                ],
                'correct_answer' => 1, // 'Verifying identity using two different methods'
            ],
            // Add more questions to reach 10-15 total
        ];

        foreach ($questions as $questionData) {
            Question::create([
                'field' => 'Network Security',
                'question' => $questionData['question'],
                'answers' => $questionData['answers'],
                'correct_answer' => $questionData['correct_answer'],
            ]);
        }
    }
}
