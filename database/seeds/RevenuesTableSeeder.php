<?php

use App\Revenue;
use Illuminate\Database\Seeder;

class RevenuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $limit = 100;

        for ($i = 0; $i < $limit; $i++) {
            Revenue::create([
                'contract_id' => rand(1, 15),
                'amount_paid' => rand(100, 300),
                'paid_on' => \Carbon\Carbon::now()->addDays(rand(-50, 50)),
                'currency' => 'GBP'
            ]);
        }
    }
}
