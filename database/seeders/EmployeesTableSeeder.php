<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Employee;
class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) { 
            Employee::create([
                'Name' => $faker->name(),
                'DateOfBirth' => $faker->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'), 
                'CICN' => $faker->numerify('0###########'),
                'PhoneNumber' => $faker->numerify('0#########'),
                'Position_ID' => $faker->numberBetween(1, 5) 
            ]); 
        }
    }
}
