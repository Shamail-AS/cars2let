<?php

use Illuminate\Database\Seeder;
use App\Driver;

class DriverTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $limit = 40;
        for($i = 0; $i < $limit; $i++)
        {
            Driver::create([
                'email'=>$faker->unique()->email,
                'name'=>$faker->firstName,
                'phone'=>$faker->phoneNumber,
                'license_no'=> rand(100000,999999),
                'dob' => $faker->date('d-m-Y')
            ]);
        }
    }
}
