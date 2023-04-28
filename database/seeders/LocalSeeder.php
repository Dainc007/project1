<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Seeders\Prod\CompetitionSeeder;
use Illuminate\Database\Seeder;

class LocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(CompetitionSeeder::class);
    }
}
