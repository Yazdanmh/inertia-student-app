<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Database\Seeder;

class ClassesSeeder extends Seeder
{
    public function run()
    {
        Classes::factory()
            ->count(10)
            ->has(
                Section::factory()
                    ->count(2)
                    ->state(
                        new \Illuminate\Database\Eloquent\Factories\Sequence(
                            ['name' => 'Section A'],
                            ['name' => 'Section B']
                        )
                    )
                    ->has(
                        Student::factory()
                            ->count(5)
                            ->state(function (array $attributes, Section $section) {
                                return [
                                    'class_id' => $section->class_id,
                                    'section_id' => $section->id,
                                ];
                            })
                    )
            )
            ->create();
    }
}
