<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\ProductSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,   
            OrderSeeder::class, 
        ]);
    }
}
