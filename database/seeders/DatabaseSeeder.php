<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Account;
use App\Models\User;
use App\Models\Category;
use App\Models\Operation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory()->create();
        // Account::factory()->create([
        //     'user_id'=>1
        // ]);
        // Category::factory(10)->create();
        // Operation::factory(10)->create();


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(UserSeeder::class);
        $this->call(AccountSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(AccountCategorySeeder::class);
        $this->call(OperationSeeder::class);
        // Category::factory(10)->create();
        // User::factory()->make()->has(Account::factory()->create())->create();
        }
}
