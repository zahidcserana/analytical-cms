<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sadmin =  User::factory()->create([
            'id' => 1,
            'name' => 'Analytical Journey',
            'email' => 'admin@analytical.com',
            'password' => Hash::make('aj$21'),
            'observe' => Carbon::now()->addMonths(12),
            'type' => User::ROLE_ADMINISTRATOR,
        ]);

        $admin =  User::factory()->create([
            'id' => 2,
            'name' => 'Analytical Journey',
            'email' => 'admin@admin.com',
            'observe' => Carbon::now()->addMonths(1),
            'type' => User::ROLE_ADMINISTRATOR,
        ]);


        $creator = User::factory()->create([
            'id' => 3,
            'email' => 'creator@cms.com',
            'type' => User::ROLE_MEMBER,
            'observe' => Carbon::now()->addDay(),
        ]);

        $member = User::factory()->create([
            'id' => 4,
            'email' => 'member@cms.com',
            'type' => User::ROLE_MEMBER,
            'observe' => Carbon::now()->addMonths(2),
        ]);
    }
}
