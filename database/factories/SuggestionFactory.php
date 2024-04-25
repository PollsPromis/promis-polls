<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\Suggestion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suggestion>
 */
class SuggestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => fake()->date(),
            'author' => fake()->name(),
            'collaborator' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => fake()->e164PhoneNumber(),
            'depart_id' => 1,
            'type_id' => 1,
            'suggestion_content' => fake()->sentence(),
            'economic_indic_id' => null,
            'sent_for_expertise' => false,
            'manager_comment' => null,
            'does_solve_a_problem' => false,
            'realizer' => null,
            'status_id' => 1,
        ];
    }
}
