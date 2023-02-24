<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-1 month', '+1 month');
        $end = fake()->dateTimeBetween('-1 month', '+1 month');
        if ($start > $end) {
            $tmp = $start;
            $start = $end;
            $end = $tmp;
        }
        $title = fake()->sentence;
        return [
            'title' => $title,
            'description' => fake()->paragraph(1),
            'body' => fake()->paragraph(5),
            'start' => $start,
            'end' => $end
        ];
    }
}
