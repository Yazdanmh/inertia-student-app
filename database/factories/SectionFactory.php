<?php

namespace Database\Factories;

use App\Models\Classes;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

class SectionFactory extends Factory
{
    protected $model = Section::class;

    public function definition()
    {
        return [
            'class_id' => Classes::factory(),
            'name' => $this->faker->randomElement(['Section A', 'Section B']),
        ];
    }
}
