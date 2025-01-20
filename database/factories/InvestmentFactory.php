<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Investment>
 */
class InvestmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $projects = Project::take(2)->get();

        if ($projects->isEmpty()) {
            $projects = Project::factory()->count(2)->create();
        }

        $project = $projects->random();

        return [
            'project_id' => $project->id,
            'investor_id' => \App\Models\Investor::factory(),
            'amount' => $this->faker->randomFloat(2, 100, 100000),
        ];
    }
}
