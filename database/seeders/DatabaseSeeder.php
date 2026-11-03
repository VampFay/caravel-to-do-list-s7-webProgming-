<?php

namespace Database\Seeders;

use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $today = Carbon::today();

        $sampleTodos = [
            [
                'title' => 'Complete Laravel To-Do Application setup',
                'description' => 'Verify SQLite database connection, run migrations, and test interactive components.',
                'completed' => true,
                'priority' => 'high',
                'due_date' => $today->toDateString(),
                'category' => 'Development',
            ],
            [
                'title' => 'Review system architecture and database schema',
                'description' => 'Verify controller methods, query optimization, and SQLite integration.',
                'completed' => true,
                'priority' => 'medium',
                'due_date' => $today->toDateString(),
                'category' => 'Engineering',
            ],
            [
                'title' => 'Design responsive UI with Tailwind CSS',
                'description' => 'Include 2-column dashboard layout, priority badges, category chips, search bar, and progress tracking.',
                'completed' => false,
                'priority' => 'high',
                'due_date' => $today->copy()->addDay()->toDateString(),
                'category' => 'Design',
            ],
            [
                'title' => 'Add inline editing and bulk actions',
                'description' => 'Allow editing task title, notes, due date and priority, plus one-click clear completed.',
                'completed' => false,
                'priority' => 'medium',
                'due_date' => $today->copy()->addDays(2)->toDateString(),
                'category' => 'Development',
            ],
            [
                'title' => 'Pick up fresh groceries for the week',
                'description' => 'Organic vegetables, almond milk, sourdough bread, and green tea.',
                'completed' => false,
                'priority' => 'low',
                'due_date' => $today->copy()->addDays(3)->toDateString(),
                'category' => 'Personal',
            ],
        ];

        foreach ($sampleTodos as $todo) {
            Todo::create($todo);
        }
    }
}
