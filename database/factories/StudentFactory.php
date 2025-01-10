<?php

namespace Database\Factories;

use App\Models\Section;
use App\Models\Classes;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        return [
            'class_id' => Classes::factory(),
            'section_id' => Section::factory(),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
