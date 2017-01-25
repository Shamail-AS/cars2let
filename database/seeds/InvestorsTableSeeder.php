<?php

use App\Investor;
use Carbon\Carbon;
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
        Investor::create([
            'email' => 'alpha@cars2let.com',
            'name' => $faker->firstName,
            'phone' => $faker->phoneNumber,
            'passport_num' => strtoupper($faker->bothify('????####')),
            'dob' => $faker->date("d-m-Y"),
            'acc_period_start' => '01-03-2015',
            'acc_period_end' => '28-02-2016',
            'tracking_url' => 'http://gpslive.co.uk/login.php?au=2FD967CDDADD7FA7F1C97DB8422CBF2E'
        ]);
        for($i = 0; $i < $limit; $i++)
        {
            Investor::create([
                'email'=>$faker->unique()->email,
                'name'=>$faker->firstName,
                'phone'=>$faker->phoneNumber,
                'passport_num' => strtoupper($faker->bothify('????####')),
                'dob' => $faker->date("d-m-Y"),
                'acc_period_start' => '01-03-2015',
                'acc_period_end' => '28-02-2016',
                'tracking_url' => 'http://gpslive.co.uk/login.php?au=2FD967CDDADD7FA7F1C97DB8422CBF2E'
            ]);
        }

    }
}
