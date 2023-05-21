<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Category;
use App\Models\Operation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PHPUnit\Framework\Constraint\Operator;

class OperationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = max((int)$this->command->ask("How Many operations would you like?"),1);
        $accounts = collect(Account::all()->modelKeys());
        $categories = collect(Category::all()->modelKeys());
        for ($i=0; $i < $count; $i++) {
            $acc = $accounts->random();
            $cat = $categories->random();
            Operation::factory()->create([
                'account_id'=>$acc,
                'category_id'=>$cat,
            ]);
        }

    }
}
