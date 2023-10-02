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
        foreach (range(1, 100) as $index) {
             DB::table('users')->insert([
                 'name' => $faker->name,
                 'phone'=> $faker->phoneNumber,
                 'email' => $faker->unique()->safeEmail,
                 'password' => $faker->password,
                 'role' => $faker->randomElement(['admin', 'driver']),
                 'status'=> $faker->randomElement(['active', 'inactive']),
             ]);
            DB::table('truck')->insert([
                'manufacturer' => $faker->randomElement(['Huyndai', 'Kia', 'Toyota', 'Mitsubishi', 'Isuzu']),
                'model' => $faker->randomElement(['Sando', 'I10', 'City', 'SVJ', 'Dmax']),
                'year' => $faker->year,
                'license_plate' => $faker->unique()->randomNumber(8),
                'vin_number' => $faker->unique()->randomNumber(8),
                'purchase_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'registration_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'curent_mileage' => $faker->randomNumber(5),
            ]);
        }
    }
}
