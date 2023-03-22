<?php

namespace Database\Factories\Events;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Image;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Events\Event>
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
        $start = Carbon::parse(fake()->dateTimeBetween('-1 week', '+1 month'))->roundMinute(30);
        $end = Carbon::parse($start)->addMinutes(fake()->numberBetween(60, 60*24*3))->roundMinute(30);
        $title = fake()->sentence;
        return [
            'title' => $title,
            'description' => fake()->paragraph(1),
            'body' => fake()->paragraph(5),
            'start' => $start,
            'end' => $end,
            'banner' => fake()->randomElement(Image::all())->id
        ];
    }
}
