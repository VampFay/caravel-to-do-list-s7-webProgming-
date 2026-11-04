<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TodoController extends Controller
{
    /**
     * Display a listing of todos with filters and stats.
     */
    public function index(Request $request): View|JsonResponse
    {
        $filter = $request->query('filter', 'all');
        $priority = $request->query('priority', 'all');
        $category = $request->query('category', 'all');
        $search = $request->query('search');
        $sort = $request->query('sort', 'latest');

        $query = Todo::query()
            ->status($filter)
            ->priority($priority)
            ->category($category)
            ->search($search);

        match ($sort) {
            'oldest' => $query->oldest('id'),
            'due_date' => $query->orderByRaw('due_date IS NULL, due_date ASC')->latest('id'),
            'priority' => $query->orderByRaw("CASE priority WHEN 'high' THEN 1 WHEN 'medium' THEN 2 WHEN 'low' THEN 3 ELSE 4 END")->latest('id'),
            default => $query->orderBy('completed')->latest('id'),
        };

        $todos = $query->get();
        $stats = $this->getStats();

        $categories = Todo::whereNotNull('category')
            ->where('category', '!=', '')
            ->selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        if ($request->expectsJson()) {
            return response()->json([
                'todos' => $todos,
                'stats' => $stats,
                'categories' => $categories,
            ]);
        }

        return view('todos.index', [
            'todos' => $todos,
            'filter' => $filter,
            'priority' => $priority,
            'category' => $category,
            'search' => $search,
            'sort' => $sort,
            'totalCount' => $stats['total'],
            'completedCount' => $stats['completed'],
            'remainingCount' => $stats['remaining'],
            'todayCount' => $stats['today'],
            'importantCount' => $stats['important'],
            'completionPercentage' => $stats['completionPercentage'],
            'categories' => $categories,
        ]);
    }

    /**
     * Store a new todo.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'priority' => ['nullable', 'in:low,medium,high'],
            'due_date' => ['nullable', 'date'],
            'category' => ['nullable', 'string', 'max:50'],
        ]);

        $validated['title'] = trim($validated['title']);
        $validated['priority'] = $validated['priority'] ?? 'medium';
        $validated['description'] = filled($validated['description'] ?? null) ? trim($validated['description']) : null;
        $validated['category'] = filled($validated['category'] ?? null) ? trim($validated['category']) : null;
        $validated['due_date'] = filled($validated['due_date'] ?? null) ? $validated['due_date'] : null;

        $todo = Todo::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Task added successfully!',
                'todo' => $todo,
                'stats' => $this->getStats(),
            ], 201);
        }

        return $this->redirectWithParams($request, 'Task added successfully!');
    }

    /**
     * Update an existing todo.
     */
    public function update(Request $request, Todo $todo): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'priority' => ['nullable', 'in:low,medium,high'],
            'due_date' => ['nullable', 'date'],
            'category' => ['nullable', 'string', 'max:50'],
        ]);

        $validated['title'] = trim($validated['title']);
        $validated['priority'] = $validated['priority'] ?? 'medium';
        $validated['description'] = filled($validated['description'] ?? null) ? trim($validated['description']) : null;
        $validated['category'] = filled($validated['category'] ?? null) ? trim($validated['category']) : null;
        $validated['due_date'] = filled($validated['due_date'] ?? null) ? $validated['due_date'] : null;

        $todo->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Task updated successfully!',
                'todo' => $todo,
                'stats' => $this->getStats(),
            ]);
        }

        return $this->redirectWithParams($request, 'Task updated successfully!');
    }

    /**
     * Toggle the completed status.
     */
    public function toggle(Request $request, Todo $todo): RedirectResponse|JsonResponse
    {
        $todo->update(['completed' => ! $todo->completed]);

        $message = $todo->completed ? 'Task completed!' : 'Task reopened.';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'todo' => $todo,
                'stats' => $this->getStats(),
            ]);
        }

        return $this->redirectWithParams($request, $message);
    }

    /**
     * Delete a todo.
     */
    public function destroy(Request $request, Todo $todo): RedirectResponse|JsonResponse
    {
        $todoId = $todo->id;
        $todo->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Task deleted.',
                'deleted_id' => $todoId,
                'stats' => $this->getStats(),
            ]);
        }

        return $this->redirectWithParams($request, 'Task deleted.');
    }

    /**
     * Clear all completed todos.
     */
    public function clearCompleted(Request $request): RedirectResponse|JsonResponse
    {
        $count = Todo::where('completed', true)->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $count > 0 ? "Cleared {$count} completed tasks!" : 'No completed tasks to clear.',
                'cleared_count' => $count,
                'stats' => $this->getStats(),
            ]);
        }

        return $this->redirectWithParams($request, $count > 0 ? "Cleared {$count} completed tasks!" : 'No completed tasks to clear.');
    }

    /**
     * Mark all active todos as completed.
     */
    public function markAllCompleted(Request $request): RedirectResponse|JsonResponse
    {
        $updated = Todo::where('completed', false)->update(['completed' => true]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $updated > 0 ? 'All tasks completed!' : 'All tasks are already completed.',
                'updated_count' => $updated,
                'stats' => $this->getStats(),
            ]);
        }

        return $this->redirectWithParams($request, $updated > 0 ? 'All tasks completed!' : 'All tasks are already completed.');
    }

    /**
     * Bulk import todos from JSON payload or uploaded file.
     */
    public function import(Request $request): JsonResponse|RedirectResponse
    {
        $items = $request->input('todos', []);

        if (empty($items) && $request->hasFile('file')) {
            $content = file_get_contents($request->file('file')->getRealPath());
            $decoded = json_decode($content, true);
            $items = $decoded['todos'] ?? (is_array($decoded) ? $decoded : []);
        } elseif (is_string($items)) {
            $decoded = json_decode($items, true);
            if (is_array($decoded)) {
                $items = $decoded['todos'] ?? $decoded;
            }
        }

        $imported = [];
        if (is_array($items)) {
            foreach ($items as $item) {
                if (! empty($item['title']) && is_string($item['title'])) {
                    $imported[] = Todo::create([
                        'title' => trim(substr($item['title'], 0, 255)),
                        'description' => filled($item['description'] ?? null) ? trim(substr($item['description'], 0, 1000)) : null,
                        'priority' => in_array($item['priority'] ?? 'medium', ['low', 'medium', 'high'], true) ? $item['priority'] : 'medium',
                        'due_date' => filled($item['due_date'] ?? null) ? $item['due_date'] : null,
                        'category' => filled($item['category'] ?? null) ? trim(substr($item['category'], 0, 50)) : null,
                        'completed' => ! empty($item['completed']),
                    ]);
                }
            }
        }

        $count = count($imported);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $count > 0 ? "Successfully imported {$count} tasks!" : 'No valid tasks found to import.',
                'imported_count' => $count,
                'todos' => $imported,
                'stats' => $this->getStats(),
            ]);
        }

        return $this->redirectWithParams($request, $count > 0 ? "Successfully imported {$count} tasks!" : 'No valid tasks found to import.');
    }

    /**
     * Calculate and return key metrics.
     */
    protected function getStats(): array
    {
        $stats = Todo::toBase()
            ->selectRaw('COUNT(*) as total, SUM(CASE WHEN completed = 1 THEN 1 ELSE 0 END) as completed')
            ->first();

        $totalCount = (int) ($stats->total ?? 0);
        $completedCount = (int) ($stats->completed ?? 0);
        $remainingCount = max(0, $totalCount - $completedCount);
        $completionPercentage = $totalCount > 0 ? (int) round(($completedCount / $totalCount) * 100) : 0;

        $todayCount = Todo::whereDate('due_date', Carbon::today())->where('completed', false)->count();
        $importantCount = Todo::where('priority', 'high')->where('completed', false)->count();

        return [
            'total' => $totalCount,
            'completed' => $completedCount,
            'remaining' => $remainingCount,
            'completionPercentage' => $completionPercentage,
            'today' => $todayCount,
            'important' => $importantCount,
        ];
    }

    /**
     * Helper to preserve active query filters when redirecting back to index.
     */
    protected function redirectWithParams(Request $request, string $flashMessage): RedirectResponse
    {
        $params = [];

        if ($request->filled('filter') && in_array($request->input('filter'), ['all', 'active', 'done', 'today', 'important'], true)) {
            if ($request->input('filter') !== 'all') {
                $params['filter'] = $request->input('filter');
            }
        }

        if ($request->filled('filter_priority') && in_array($request->input('filter_priority'), ['low', 'medium', 'high'], true)) {
            $params['priority'] = $request->input('filter_priority');
        }

        if ($request->filled('filter_category') && $request->input('filter_category') !== 'all') {
            $params['category'] = $request->input('filter_category');
        }

        if ($request->filled('search')) {
            $params['search'] = $request->input('search');
        }

        if ($request->filled('sort') && in_array($request->input('sort'), ['due_date', 'priority', 'oldest'], true)) {
            $params['sort'] = $request->input('sort');
        }

        return redirect()->route('todos.index', $params)->with('success', $flashMessage);
    }
}
