<?php

namespace Database\Factories;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Todo>
 */
class TodoFactory extends Factory
{
    protected $model = Todo::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->boolean(60) ? fake()->paragraph(1) : null,
            'completed' => fake()->boolean(25),
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'due_date' => fake()->boolean(70) ? fake()->dateTimeBetween('-2 days', '+10 days')->format('Y-m-d') : null,
            'category' => fake()->randomElement(['Work', 'Personal', 'Study', 'Shopping', 'Health']),
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'completed' => true,
        ]);
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'completed' => false,
        ]);
    }

    public function highPriority(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => 'high',
        ]);
    }
}
