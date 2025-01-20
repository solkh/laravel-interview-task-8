<?php

namespace Database\Seeders;

use App\Models\Borrower;
use App\Models\Investment;
use App\Models\Investor;
use App\Models\Project;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        Borrower::factory(1)->create();
        Investment::factory(50)->create();
    }
}
