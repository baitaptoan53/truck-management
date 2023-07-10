<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');
        foreach (range(1, 100) as $index) 
        {
            DB::table('users')->insert([
                'name' => $faker->name,
                'phone'=> $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'password' => $faker->password,
                'role' => $faker->randomElement(['admin', 'driver']),
                'status'=> $faker->randomElement(['active', 'inactive']),
            ]);
        }
    }
}
