<?php

use Illuminate\Database\Seeder;
use \App\Car;

class CarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    function getMake()
    {
        $makes = [
            'Ford',
            'Mustang',
            'Honda',
            'Toyota',
            'Audi',
            'Ferrari',
            'Suzuki',
            'RollsRoyce'
        ];
        return $makes[rand(0,count($makes)-1)];
    }
    public function run()
    {
        //
        $faker = Faker\Factory::create();
        for($i = 0; $i < 50; $i++)
        {
            Car::create([
                'reg_no'=> strtoupper(str_random(3))."-".strtoupper(str_random(3)),
                'make'=>$faker->colorName,
                'investor_id' => $faker->biasedNumberBetween(1,10),
                'available_since'=>$faker->date('d-m-Y'),
                'comments'=>'',
            ]);
        }


    }
}
