<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(5)
            ->hasCart(rand(1,5))
            ->create();
        
        User::factory()
            ->count(5)
            ->create();

        User::factory()
            ->count(3)
            ->create([
                'role' => 'ADMIN'
            ]);
    }
}
