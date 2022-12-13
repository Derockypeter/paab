<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $professions = [
            [
                'name' => 'Doctor',
                'title_id' => 3,
            ],
            [
                'name' => 'Tutor',
                'title_id' => 2,
            ],
            [
                'name' => 'Photographer',
                'title_id' => 1,
            ],
            [
                'name' => 'Trainer',
                'title_id' => 4,
            ],
            [
                'name' => 'Lawyer',
                'title_id' => 6,
            ],
            [
                'name' => 'Physician',
                'title_id' => 3,
            ]
            ];
            collect($professions)->each(function ($professions) {\App\Models\Profession::create($professions);});
    }
}