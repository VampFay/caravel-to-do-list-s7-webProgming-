<?php

namespace Tests\Feature;

use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    public function test_todo_index_page_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Fay Tasks');
    }

    public function test_can_create_a_basic_todo(): void
    {
        $response = $this->post(route('todos.store'), [
            'title' => 'Buy organic milk',
        ]);

        $response->assertRedirect(route('todos.index'));
        $this->assertDatabaseHas('todos', [
            'title' => 'Buy organic milk',
            'completed' => false,
            'priority' => 'medium',
        ]);
    }

    public function test_can_create_a_todo_with_all_metadata(): void
    {
        $response = $this->post(route('todos.store'), [
            'title' => 'Prepare product release notes',
            'description' => 'Document all breaking changes and new endpoints.',
            'priority' => 'high',
            'due_date' => '2026-11-10',
            'category' => 'Engineering',
        ]);

        $response->assertRedirect(route('todos.index'));
        $this->assertDatabaseHas('todos', [
            'title' => 'Prepare product release notes',
            'description' => 'Document all breaking changes and new endpoints.',
            'priority' => 'high',
            'category' => 'Engineering',
        ]);
    }

    public function test_title_is_required_to_create_todo(): void
    {
        $response = $this->post(route('todos.store'), [
            'title' => '',
        ]);

        $response->assertSessionHasErrors(['title']);
        $this->assertDatabaseCount('todos', 0);
    }

    public function test_title_cannot_exceed_255_characters(): void
    {
        $response = $this->post(route('todos.store'), [
            'title' => str_repeat('a', 256),
        ]);

        $response->assertSessionHasErrors(['title']);
        $this->assertDatabaseCount('todos', 0);
    }

    public function test_can_toggle_todo_completion_status(): void
    {
        $todo = Todo::create([
            'title' => 'Write automated tests',
            'completed' => false,
        ]);

        // Toggle to true
        $response = $this->patch(route('todos.toggle', $todo));
        $response->assertRedirect(route('todos.index'));
        $this->assertTrue($todo->fresh()->completed);

        // Toggle back to false
        $this->patch(route('todos.toggle', $todo));
        $this->assertFalse($todo->fresh()->completed);
    }

    public function test_can_update_a_todo(): void
    {
        $todo = Todo::create([
            'title' => 'Original Title',
            'priority' => 'low',
        ]);

        $response = $this->put(route('todos.update', $todo), [
            'title' => 'Updated Title',
            'description' => 'Added detailed notes',
            'priority' => 'high',
            'category' => 'Work',
        ]);

        $response->assertRedirect(route('todos.index'));
        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'title' => 'Updated Title',
            'priority' => 'high',
            'category' => 'Work',
        ]);
    }

    public function test_can_delete_a_todo(): void
    {
        $todo = Todo::create([
            'title' => 'Delete this later',
        ]);

        $response = $this->delete(route('todos.destroy', $todo));

        $response->assertRedirect(route('todos.index'));
        $this->assertDatabaseMissing('todos', [
            'id' => $todo->id,
        ]);
    }

    public function test_can_filter_active_and_completed_todos(): void
    {
        Todo::create(['title' => 'Active Task 1', 'completed' => false]);
        Todo::create(['title' => 'Completed Task 2', 'completed' => true]);

        // Active filter
        $responseActive = $this->get(route('todos.index', ['filter' => 'active']));
        $responseActive->assertSee('Active Task 1');
        $responseActive->assertDontSee('Completed Task 2');

        // Completed filter
        $responseDone = $this->get(route('todos.index', ['filter' => 'done']));
        $responseDone->assertSee('Completed Task 2');
        $responseDone->assertDontSee('Active Task 1');
    }

    public function test_can_search_todos(): void
    {
        Todo::create(['title' => 'Inspect database logs', 'completed' => false]);
        Todo::create(['title' => 'Buy apples and oranges', 'completed' => false]);

        $response = $this->get(route('todos.index', ['search' => 'database']));
        $response->assertSee('Inspect database logs');
        $response->assertDontSee('Buy apples and oranges');
    }

    public function test_can_filter_by_priority(): void
    {
        Todo::create(['title' => 'Critical security update', 'priority' => 'high']);
        Todo::create(['title' => 'Water office plants', 'priority' => 'low']);

        $response = $this->get(route('todos.index', ['priority' => 'high']));
        $response->assertSee('Critical security update');
        $response->assertDontSee('Water office plants');
    }

    public function test_can_filter_by_category(): void
    {
        Todo::create(['title' => 'Gym workout session', 'category' => 'Health']);
        Todo::create(['title' => 'Fix Docker network bug', 'category' => 'DevOps']);

        $response = $this->get(route('todos.index', ['category' => 'Health']));
        $response->assertSee('Gym workout session');
        $response->assertDontSee('Fix Docker network bug');
    }

    public function test_can_sort_todos_by_due_date(): void
    {
        $today = Carbon::today();
        Todo::create(['title' => 'Due in 5 days', 'due_date' => $today->copy()->addDays(5)]);
        Todo::create(['title' => 'Due tomorrow', 'due_date' => $today->copy()->addDay()]);

        $response = $this->get(route('todos.index', ['sort' => 'due_date']));
        $response->assertStatus(200);
        $response->assertSeeInOrder(['Due tomorrow', 'Due in 5 days']);
    }

    public function test_can_sort_todos_by_priority(): void
    {
        Todo::create(['title' => 'Low priority item', 'priority' => 'low']);
        Todo::create(['title' => 'High priority item', 'priority' => 'high']);

        $response = $this->get(route('todos.index', ['sort' => 'priority']));
        $response->assertStatus(200);
        $response->assertSeeInOrder(['High priority item', 'Low priority item']);
    }

    public function test_can_clear_completed_todos(): void
    {
        Todo::create(['title' => 'Done task 1', 'completed' => true]);
        Todo::create(['title' => 'Done task 2', 'completed' => true]);
        Todo::create(['title' => 'Still active', 'completed' => false]);

        $response = $this->post(route('todos.clearCompleted'));
        $response->assertRedirect(route('todos.index'));

        $this->assertDatabaseCount('todos', 1);
        $this->assertDatabaseHas('todos', ['title' => 'Still active']);
    }

    public function test_can_mark_all_todos_as_completed(): void
    {
        Todo::create(['title' => 'Task A', 'completed' => false]);
        Todo::create(['title' => 'Task B', 'completed' => false]);

        $response = $this->post(route('todos.markAllCompleted'));
        $response->assertRedirect(route('todos.index'));

        $this->assertEquals(0, Todo::where('completed', false)->count());
        $this->assertEquals(2, Todo::where('completed', true)->count());
    }

    public function test_updating_non_existent_todo_returns_404(): void
    {
        $response = $this->put('/todos/999999', [
            'title' => 'Non existent',
        ]);

        $response->assertStatus(404);
    }

    public function test_toggling_non_existent_todo_returns_404(): void
    {
        $response = $this->patch('/todos/999999/toggle');

        $response->assertStatus(404);
    }

    public function test_json_can_create_and_toggle_todo(): void
    {
        $response = $this->postJson(route('todos.store'), [
            'title' => 'Instant reactive task',
            'priority' => 'high',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'todo' => [
                'title' => 'Instant reactive task',
                'priority' => 'high',
                'completed' => false,
            ],
        ]);

        $todoId = $response->json('todo.id');

        $toggleResponse = $this->patchJson(route('todos.toggle', $todoId));
        $toggleResponse->assertStatus(200);
        $toggleResponse->assertJson([
            'success' => true,
            'todo' => [
                'id' => $todoId,
                'completed' => true,
            ],
        ]);
    }
}
