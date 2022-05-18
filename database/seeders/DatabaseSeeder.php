<?php

namespace Database\Seeders;

use App\Models\Clazss;
use App\Models\Major;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
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
        Subject::factory(10)->create();
        Student::factory(200)->create();

        \App\Models\User::create([
            "name" => "Superadmin",
            "email" => "superadmin@gmail.com",
            "password" => Hash::make("123"),
            "role" => 'superadmin'
        ]);
    }
}
