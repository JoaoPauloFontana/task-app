<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_can_be_create(): void
    {
        $data = [
            'name' => 'task test',
            'description' => 'descritption test'
        ];

        $response = $this->postJson(route('tasks.store'), $data);

        $this->assertDatabaseHas('tasks', $data);
        $response->assertCreated();
    }

    public function test_invalid_payload(): void
    {
        $data = [
            'description' => 6
        ];

        $response = $this->postJson(route('tasks.store'), $data);

        $response->assertJsonValidationErrors([
            'name' => __('validation.required', ['attribute' => 'name']),
            'description' => __('validation.string', ['attribute' => 'description']),
        ]);
    }

    public function test_invalid_name_payload(): void
    {
        $data = [
            'name' => 6
        ];

        $response = $this->postJson(route('tasks.store'), $data);

        $response->assertJsonValidationErrors([
            'name' => __('validation.string', ['attribute' => 'name']),
        ]);
    }

    public function test_invalid_max_payload(): void
    {
        $data = [
            'name' => str_repeat('maxstring1', 26),
            'description' => str_repeat('maxstring1', 26)
        ];

        $response = $this->postJson(route('tasks.store'), $data);

        $response->assertJsonValidationErrors([
            'name' =>'The name field must not be greater than 255 characters.',
            'description' => 'The description field must not be greater than 255 characters.',
        ]);
    }

    public function test_can_list_tasks(): void
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson(route('tasks.index'));

        $response->assertOk();
        $response->assertJsonStructure(['tasks']);
    }

    public function test_update_task(): void
    {
        $task = Task::factory()->create();
        $data = [
            'name' => 'test update name',
            'description' => 'test update description',
        ];

        $response = $this->putJson(route('tasks.update', $task), $data);

        $task->refresh();

        $this->assertEquals(
            ['test update name','test update description'],
            [$task->name, $task->description]
        );
        $response->assertOk();
    }

    public function test_invalid_string_update_payload(): void
    {
        $task = Task::factory()->create();
        $data = [
            'name' => 6,
            'description' => 6
        ];

        $response = $this->putJson(route('tasks.update', $task), $data);

        $response->assertJsonValidationErrors([
            'name' => __('validation.string', ['attribute' => 'name']),
            'description' => __('validation.string', ['attribute' => 'description']),
        ]);
    }

    public function test_invalid_max_update_payload(): void
    {
        $task = Task::factory()->create();
        $data = [
            'name' => str_repeat('maxstring1', 26),
            'description' => str_repeat('maxstring1', 26)
        ];

        $response = $this->putJson(route('tasks.update', $task), $data);

        $response->assertJsonValidationErrors([
            'name' =>'The name field must not be greater than 255 characters.',
            'description' => 'The description field must not be greater than 255 characters.',
        ]);
    }

    public function test_update_non_existing_task(): void
    {
        $data = [
            'name' => 'test update name',
            'description', 'test update description',
        ];

        $response = $this->putJson(route('tasks.update', 1), $data);

        $response->assertNotFound();
    }

    public function test_delete_non_existing_task(): void
    {

        $response = $this->deleteJson(route('tasks.update', 1));

        $response->assertNotFound();
    }

    public function test_delete_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson(route('tasks.destroy', $task));

        $response->assertOk();
        $this->assertDatabaseMissing('tasks', [
            'id' => $task
        ]);
    }
}
