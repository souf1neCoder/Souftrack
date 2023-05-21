<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\AccountCategory;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = Account::all()->modelKeys();
        $categories = Category::where('is_default',true)->get()->modelKeys();
        foreach ($accounts as $acc) {
            foreach ($categories as $cat) {
                AccountCategory::create([
                    'account_id'=>$acc,
                    'category_id'=>$cat
                ]);
            }
        }
    }
}
