<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin =  User::factory()->create([
            'id' => 1,
            'email' => 'admin@cms.com',
            'type' => User::ROLE_ADMINISTRATOR,
        ]);

        $creator = User::factory()->create([
            'id' => 2,
            'email' => 'creator@cms.com',
            'type' => User::ROLE_MEMBER,
        ]);

        $member = User::factory()->create([
            'id' => 3,
            'email' => 'member@cms.com',
            'type' => User::ROLE_MEMBER,
        ]);
    }
}
