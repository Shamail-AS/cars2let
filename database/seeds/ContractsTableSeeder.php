<?php

use App\Contract;
use Illuminate\Database\Seeder;

class ContractsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $limit = 30;
        for ($i = 0; $i < $limit; $i++) {

            $date = \Carbon\Carbon::now()->addWeeks(rand(-4, 4));
            $end_date = $date->copy()->addWeeks(rand(1, 5))->addDays($i);
            Contract::create([
                'car_id' => rand(1, 20),
                'driver_id' => rand(1, 40),
                'status' => rand(1, 4),
                'start_date' => $date,
                'end_date' => $end_date,
                'rate' => rand(20, 40),
                'currency' => 'GBP'
            ]);
        }
    }

}
