<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NoteController extends Controller
{
    /**
     * Display a listing of notes.
     */
    public function index(Request $request): View|JsonResponse
    {
        $search = $request->query('search');
        $category = $request->query('category', 'all');
        $color = $request->query('color', 'all');

        $query = Note::query()
            ->search($search)
            ->category($category)
            ->color($color)
            ->orderByDesc('is_pinned')
            ->latest('updated_at');

        $notes = $query->get();
        $stats = $this->getStats();

        $categories = Note::whereNotNull('category')
            ->where('category', '!=', '')
            ->selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        if ($request->expectsJson()) {
            return response()->json([
                'notes' => $notes,
                'stats' => $stats,
                'categories' => $categories,
            ]);
        }

        // Active note to display in editor pane
        $activeNoteId = $request->query('note');
        $activeNote = $activeNoteId ? $notes->firstWhere('id', (int) $activeNoteId) : $notes->first();

        return view('notes.index', [
            'notes' => $notes,
            'activeNote' => $activeNote,
            'search' => $search,
            'category' => $category,
            'color' => $color,
            'stats' => $stats,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created note.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string', 'max:50000'],
            'color' => ['nullable', 'in:default,amber,emerald,sky,purple,rose,indigo'],
            'category' => ['nullable', 'string', 'max:50'],
            'is_pinned' => ['nullable', 'boolean'],
        ]);

        $title = filled($validated['title'] ?? null) ? trim($validated['title']) : 'Untitled Note';

        $note = Note::create([
            'title' => $title,
            'content' => $validated['content'] ?? null,
            'color' => $validated['color'] ?? 'default',
            'category' => filled($validated['category'] ?? null) ? trim($validated['category']) : null,
            'is_pinned' => (bool) ($validated['is_pinned'] ?? false),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Note created!',
                'note' => $note,
                'stats' => $this->getStats(),
            ], 201);
        }

        return redirect()->route('notes.index', ['note' => $note->id])->with('success', 'Note created!');
    }

    /**
     * Display a single note as JSON.
     */
    public function show(Request $request, Note $note): View|JsonResponse
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'note' => $note,
            ]);
        }

        return redirect()->route('notes.index', ['note' => $note->id]);
    }

    /**
     * Update an existing note (supports debounced auto-save).
     */
    public function update(Request $request, Note $note): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string', 'max:50000'],
            'color' => ['nullable', 'in:default,amber,emerald,sky,purple,rose,indigo'],
            'category' => ['nullable', 'string', 'max:50'],
            'is_pinned' => ['nullable', 'boolean'],
        ]);

        $title = filled($validated['title'] ?? null) ? trim($validated['title']) : 'Untitled Note';

        $note->update([
            'title' => $title,
            'content' => $validated['content'] ?? null,
            'color' => $validated['color'] ?? $note->color,
            'category' => filled($validated['category'] ?? null) ? trim($validated['category']) : null,
            'is_pinned' => array_key_exists('is_pinned', $validated) ? (bool) $validated['is_pinned'] : $note->is_pinned,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Saved',
                'note' => $note->fresh(),
                'stats' => $this->getStats(),
            ]);
        }

        return redirect()->route('notes.index', ['note' => $note->id])->with('success', 'Note updated!');
    }

    /**
     * Toggle pinned status.
     */
    public function togglePin(Request $request, Note $note): RedirectResponse|JsonResponse
    {
        $note->update(['is_pinned' => ! $note->is_pinned]);

        $message = $note->is_pinned ? 'Note pinned to top 📌' : 'Note unpinned.';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'is_pinned' => $note->is_pinned,
                'note' => $note,
                'stats' => $this->getStats(),
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Delete a note.
     */
    public function destroy(Request $request, Note $note): RedirectResponse|JsonResponse
    {
        $deletedId = $note->id;
        $note->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Note deleted.',
                'deleted_id' => $deletedId,
                'stats' => $this->getStats(),
            ]);
        }

        return redirect()->route('notes.index')->with('success', 'Note deleted.');
    }

    /**
     * Convert note into a To-Do item.
     */
    public function convertToTodo(Request $request, Note $note): RedirectResponse|JsonResponse
    {
        $todo = Todo::create([
            'title' => $note->title !== 'Untitled Note' ? $note->title : 'Review note: '.Str::limit($note->snippet, 40),
            'description' => $note->content,
            'priority' => 'medium',
            'category' => $note->category ?? 'Notes',
            'completed' => false,
        ]);

        $note->update(['todo_id' => $todo->id]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Converted note to task!',
                'todo' => $todo,
                'note' => $note,
            ]);
        }

        return redirect()->route('todos.index')->with('success', 'Converted note to task!');
    }

    /**
     * Compute note metrics.
     */
    protected function getStats(): array
    {
        $total = Note::count();
        $pinned = Note::where('is_pinned', true)->count();
        $totalWords = Note::all()->sum(fn ($n) => $n->word_count);

        return [
            'total' => $total,
            'pinned' => $pinned,
            'words' => $totalWords,
        ];
    }
}
