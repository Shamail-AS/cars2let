<?php

use App\Investor;
use Illuminate\Database\Seeder;

class InvestorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $limit = 33;
        for($i = 0; $i < $limit; $i++)
        {
            Investor::create([
                'email'=>$faker->unique()->email,
                'name'=>$faker->firstName,
                'phone'=>$faker->phoneNumber,
                'passport_num'=>$faker->bothify('????####'),
                'dob' => $faker->date()
            ]);
        }
    }
}
