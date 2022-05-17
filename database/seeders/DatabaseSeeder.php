<?php

namespace Database\Seeders;

use App\Models\Clazss;
use App\Models\Major;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Teacher::factory(200)->create();
        Major::factory(10)->create();
        Clazss::factory(100)->create();
        $this->call(RoleSeeder::class);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            "name" => "Superadmin",
            "email" => "superadmin@gmail.com",
            "password" => Hash::make("123"),
            "role_id" => 1
        ]);
    }
}
