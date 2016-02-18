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
        //
        Driver::create([
            'email'=>'lemma@cars2let.com',
            'name'=>'Lemma',
            'phone'=>'07999978034',
            'license_no'=> rand(100000,999999),
            'dob' => \Carbon\Carbon::now()->addYears(rand(-50,-15))
        ]);
        Driver::create([
            'email'=>'gemma@cars2let.com',
            'name'=>'Gemma',
            'phone'=>'074756978034',
            'license_no'=> rand(100000,999999),
            'dob' => \Carbon\Carbon::now()->addYears(rand(-50,-15))
        ]);
        Driver::create([
            'email'=>'memma@cars2let.com',
            'name'=>'Memma',
            'phone'=>'074545238034',
            'license_no'=> rand(100000,999999),
            'dob' => \Carbon\Carbon::now()->addYears(rand(-50,-15))
        ]);
        Driver::create([
            'email'=>'hemma@cars2let.com',
            'name'=>'Hemma',
            'phone'=>'07454929434',
            'license_no'=> rand(100000,999999),
            'dob' => \Carbon\Carbon::now()->addYears(rand(-50,-15))
        ]);
    }
}
