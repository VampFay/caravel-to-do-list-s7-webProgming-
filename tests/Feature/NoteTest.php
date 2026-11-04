<?php

namespace Tests\Feature;

use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_notes_index_page_loads_successfully(): void
    {
        Note::create([
            'title' => 'Sample Note',
            'content' => 'Sample note content for testing.',
        ]);

        $response = $this->get(route('notes.index'));
        $response->assertStatus(200);
        $response->assertSee('Sample Note');
    }

    public function test_can_create_a_note(): void
    {
        $response = $this->post(route('notes.store'), [
            'title' => 'Project Brainstorming',
            'content' => 'Ideas for the next release.',
            'color' => 'indigo',
            'category' => 'Ideas',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('notes', [
            'title' => 'Project Brainstorming',
            'color' => 'indigo',
            'category' => 'Ideas',
        ]);
    }

    public function test_can_update_a_note_via_json_auto_save(): void
    {
        $note = Note::create([
            'title' => 'Draft Title',
            'content' => 'Initial scratchpad text.',
        ]);

        $response = $this->putJson(route('notes.update', $note), [
            'title' => 'Polished Title',
            'content' => 'Updated comprehensive notes.',
            'color' => 'emerald',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Saved',
            'note' => [
                'id' => $note->id,
                'title' => 'Polished Title',
                'color' => 'emerald',
            ],
        ]);

        $this->assertEquals('Polished Title', $note->fresh()->title);
        $this->assertEquals('Updated comprehensive notes.', $note->fresh()->content);
    }

    public function test_can_toggle_note_pin_status(): void
    {
        $note = Note::create([
            'title' => 'Pinnable note',
            'is_pinned' => false,
        ]);

        // Toggle to pinned
        $response = $this->patchJson(route('notes.pin', $note));
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'is_pinned' => true,
        ]);
        $this->assertTrue($note->fresh()->is_pinned);

        // Toggle back to unpinned
        $this->patchJson(route('notes.pin', $note));
        $this->assertFalse($note->fresh()->is_pinned);
    }

    public function test_can_delete_a_note(): void
    {
        $note = Note::create(['title' => 'To be deleted']);

        $response = $this->deleteJson(route('notes.destroy', $note));
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseMissing('notes', ['id' => $note->id]);
    }

    public function test_can_convert_note_to_todo_task(): void
    {
        $note = Note::create([
            'title' => 'Draft API specification',
            'content' => 'Define POST /notes and PUT /notes endpoints.',
            'category' => 'Engineering',
        ]);

        $response = $this->postJson(route('notes.convertToTodo', $note));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Converted note to task!',
        ]);

        $this->assertDatabaseHas('todos', [
            'title' => 'Draft API specification',
            'description' => 'Define POST /notes and PUT /notes endpoints.',
            'category' => 'Engineering',
        ]);

        $this->assertNotNull($note->fresh()->todo_id);
    }

    public function test_can_filter_notes_by_search_term(): void
    {
        Note::create(['title' => 'Meeting with UX Team', 'content' => 'Discussed glass fluid design.']);
        Note::create(['title' => 'Grocery Checklist', 'content' => 'Buy organic apples.']);

        $response = $this->get(route('notes.index', ['search' => 'UX']));
        $response->assertStatus(200);
        $response->assertSee('Meeting with UX Team');
        $response->assertDontSee('Grocery Checklist');
    }

    public function test_can_fetch_notes_as_json(): void
    {
        Note::create(['title' => 'JSON Note 1']);
        Note::create(['title' => 'JSON Note 2']);

        $response = $this->getJson(route('notes.index'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'notes',
            'stats' => ['total', 'pinned', 'words'],
            'categories',
        ]);
        $this->assertCount(2, $response->json('notes'));
    }

    public function test_color_validation_on_note_update(): void
    {
        $note = Note::create(['title' => 'Color test']);

        $response = $this->putJson(route('notes.update', $note), [
            'color' => 'invalid-neon-color',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['color']);
    }
}
