<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::query()->select('id','username')->get();
        $users->each(function($user){
            Account::factory()->create([
                'account_image'=> env('AVATAR_API') . $user['username'],
                'user_id'=>$user['id']
            ]);
        });
    }
}
