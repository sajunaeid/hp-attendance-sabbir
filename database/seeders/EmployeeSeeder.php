<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();


        foreach (range(1, 30) as $index) {
            $user = Employee::create([
                'name' => $faker->name,
                'phone' => $faker->e164PhoneNumber ,
                'nid' => $faker->isbn13,
                'emp_id' => $faker->swiftBicNumber ,
                'emp_number' => $faker->unixTime($max = 'now') ,
                'wh' => 7,
                'score'=> $faker->biasedNumberBetween($min = 100, $max = 999, $function = 'sqrt'),
            ]);
        }
    }
}
