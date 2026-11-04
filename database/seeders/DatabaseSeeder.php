<?php

namespace Database\Seeders;

use App\Models\Note;
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

        $sampleNotes = [
            [
                'title' => '🚀 Architecture & Glass Fluid Design Notes',
                'content' => "### Core Architectural Pillars\n\n1. **Glass Fluid UI**: Frosted glass panels with 24px saturate backdrop blur, fluid ambient blobs, and 400ms cubic-bezier theme morphing.\n2. **60fps Optimistic Engine**: Zero-reload checkbox toggling, instant DOM prepend with spring drop-in, and debounced auto-saving.\n3. **Web Audio Synthesizer**: Pure in-browser vintage Rhodes chords and analog vinyl crackle.\n\n*Everything is engineered for speed, joy, and distraction-free deep work.*",
                'color' => 'indigo',
                'is_pinned' => true,
                'category' => 'Engineering',
            ],
            [
                'title' => '💡 Product Brainstorm & Future Enhancements',
                'content' => "### Feature Roadmap Ideas\n\n- [x] Vim-style keyboard navigation (J/K/Space/E/Del)\n- [x] Dual Lo-Fi tracks (Rainy Cafe & Midnight Nebula)\n- [x] 1-Click JSON & Markdown task export/import\n- [x] Scratchpad & Notes workspace integration\n- [ ] Natural language date parser (e.g., 'submit report by Friday 5pm')\n- [ ] Mobile PWA offline caching",
                'color' => 'amber',
                'is_pinned' => true,
                'category' => 'Ideas',
            ],
            [
                'title' => '🎧 Lo-Fi Chord Theory & Synthesizer Guide',
                'content' => "Notes on the Web Audio API generative chord progressions:\n\n- **Rainy Cafe (72 BPM)**: Dm9 (146Hz) ➔ G13 (98Hz) ➔ Cmaj9 (130Hz) ➔ Am9 (110Hz). Filter lowpass 650Hz.\n- **Midnight Nebula (52 BPM)**: Fmaj9 (174Hz) ➔ Em7 (164Hz) ➔ Dm9 (146Hz) ➔ Cmaj7 (130Hz). Filter lowpass 420Hz.\n- Melodic chimes use high pentatonic bell frequencies (C5 to C6) at random intervals.",
                'color' => 'purple',
                'is_pinned' => false,
                'category' => 'Audio',
            ],
            [
                'title' => '☕️ Morning Scratchpad & Standup Notes',
                'content' => "Key objectives for today's session:\n\n- Ship Notes app integration with auto-save and glass dual-pane layout\n- Verify seamless task conversion\n- Keep streak burning at 100% 🔥\n- Drink more water between Pomodoros!",
                'color' => 'emerald',
                'is_pinned' => false,
                'category' => 'Scratchpad',
            ],
        ];

        foreach ($sampleNotes as $note) {
            Note::create($note);
        }
    }
}
