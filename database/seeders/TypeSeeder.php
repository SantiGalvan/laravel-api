<?php

namespace Database\Seeders;

use App\Models\Type;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker): void
    {
        $types = [
            [
                'label' => 'FrontEnd',
                'color' => '#F4E76E'
            ],
            [
                'label' => 'BackEnd',
                'color' => '#757761'
            ],
            [
                'label' => 'UI/UX',
                'color' => '#8FF7A7'
            ],
            [
                'label' => 'FullStack',
                'color' => '#51BBFE'
            ],
            [
                'label' => 'Design',
                'color' => '#ECA400'
            ]
        ];

        foreach ($types as $type) {
            $new_type = new Type();

            $new_type->description = $faker->paragraphs(10, true);
            $new_type->fill($type);

            $new_type->save();
        }
    }
}
