<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $title = fake()->text(20);

        Storage::makeDirectory('project_images');

        $img_url = Storage::putFileAs('project_images', fake()->image(null, 250, 250), "$title.png");

        $type_ids = Type::pluck('id')->toArray();
        $type_ids[] = null;

        return [
            'title' => $title,
            'description' => fake()->paragraphs(10, true),
            'type_id' => Arr::random($type_ids),
            'framework' => fake()->word(),
            'image' => $img_url
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Project $project) {
            $technology_ids = Technology::pluck('id')->toArray();

            $project_technologies = array_filter($technology_ids, fn () => rand(0, 1));

            $project->technologies()->attach($project_technologies);
        });
    }
}
