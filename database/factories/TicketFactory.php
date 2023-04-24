<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          'title' => fake()->sentence(),
          'type' => fake()->randomElement(['Demande d\'amélioration', 'Idée d\'amélioration', 'Problème technique']),
          'priority' => fake()->randomElement(['Faible', 'Moyenne', 'Haute']),
          'description' => fake()->paragraph(),
          'context' => fake()->sentence(),
          'link' => fake()->url(),
          'browser' => fake()->userAgent(),
          'os' => fake()->randomElement(['Windows', 'macOS', 'Linux']),
          'status' => fake()->randomElement(['Ouvert', 'Fermé', 'En attente']),
          'creator_id' => \App\Models\User::factory()->create()->id,
          'project_id' => \App\Models\Project::factory()->create()->id,
        ];
    }

}
