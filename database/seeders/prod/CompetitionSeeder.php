<?php

declare(strict_types=1);

namespace Database\Seeders\prod;

use App\Models\Competition;
use Illuminate\Database\Seeder;

class CompetitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Competition::factory(100)->create();
    }
}
