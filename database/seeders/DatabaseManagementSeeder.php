<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class DatabaseManagementSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            [
                'question' => 'What is a primary key in a database?',
                'answers' => [
                    'A key that opens the database',
                    'A unique identifier for a record in a table',
                    'The first column in a table',
                    'A password for accessing the database'
                ],
                'correct_answer' => 1, // 'A unique identifier for a record in a table'
            ],
            [
                'question' => 'What is the difference between SQL and NoSQL databases?',
                'answers' => [
                    'SQL is faster, NoSQL is slower',
                    'SQL uses tables, NoSQL uses documents or key-value pairs',
                    'SQL is open-source, NoSQL is proprietary',
                    'SQL is for small data, NoSQL is for big data only'
                ],
                'correct_answer' => 1, // 'SQL uses tables, NoSQL uses documents or key-value pairs'
            ],
            [
                'question' => 'What is normalization in database design?',
                'answers' => [
                    'Making all data uppercase',
                    'Organizing data to reduce redundancy',
                    'Encrypting sensitive data',
                    'Compressing the database to save space'
                ],
                'correct_answer' => 1, // 'Organizing data to reduce redundancy'
            ],
            [
                'question' => 'What is an index in a database?',
                'answers' => [
                    'A list of all tables',
                    'A data structure that improves the speed of data retrieval',
                    'The first row of a table',
                    'A backup of the database'
                ],
                'correct_answer' => 1, // 'A data structure that improves the speed of data retrieval'
            ],
            [
                'question' => 'What is ACID in the context of databases?',
                'answers' => [
                    'A type of database',
                    'A database cleaning process',
                    'Properties of database transactions (Atomicity, Consistency, Isolation, Durability)',
                    'An alternative to SQL'
                ],
                'correct_answer' => 2,
                // 'Properties of database transactions (Atomicity, Consistency, Isolation, Durability)'
            ],
            // Add more questions to reach 10-15 total
        ];

        foreach ($questions as $questionData) {
            Question::create([
                'field' => 'Database Management',
                'question' => $questionData['question'],
                'answers' => $questionData['answers'],
                'correct_answer' => $questionData['correct_answer'],
            ]);
        }
    }
}
