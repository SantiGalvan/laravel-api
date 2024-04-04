<?php

namespace Database\Seeders;

use App\Models\Technology;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker): void
    {
        $techhnologies = [
            [
                'label' => 'HTML', 'color' => '#f16529'
            ],
            [
                'label' => 'CSS', 'color' => '#2465f1'
            ],
            [
                'label' => 'JS', 'color' => '#ffd600'
            ],
            [
                'label' => 'Vue', 'color' => '#00c180'
            ],
            [
                'label' => 'Bootstrap', 'color' => '#7409f6'
            ],
            [
                'label' => 'Laravel', 'color' => '#d53434'
            ],
            [
                'label' => 'SQL', 'color' => '#f29111'
            ],
            [
                'label' => 'PHP', 'color' => '#787cb4'
            ]
        ];

        foreach ($techhnologies as $technology) {
            $new_technology = new Technology();

            $new_technology->description = $faker->paragraphs(10, true);
            $new_technology->slug = Str::slug($technology['label']);
            $new_technology->fill($technology);

            $new_technology->save();
        }
    }
}
