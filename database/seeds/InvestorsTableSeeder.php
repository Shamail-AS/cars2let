<?php

use App\Investors;
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
        //
        Investors::create([
            'email'=>'alpha@cars2let.com',
            'name'=>'Alpha',
            'phone'=>'07454978034',
            'passport_num'=>'ABCD12345'
        ]);
        Investors::create([
            'email'=>'beta@cars2let.com',
            'name'=>'Beta',
            'phone'=>'07454978035',
            'passport_num'=>'ABCD12346'
        ]);
        Investors::create([
            'email'=>'gamma@cars2let.com',
            'name'=>'Gamma',
            'phone'=>'07454978036',
            'passport_num'=>'ABCD12347'
        ]);
        Investors::create([
            'email'=>'delta@cars2let.com',
            'name'=>'Delta',
            'phone'=>'07454978037',
            'passport_num'=>'ABCD12348'
        ]);
        Investors::create([
            'email'=>'omega@cars2let.com',
            'name'=>'Omega',
            'phone'=>'07454978038',
            'passport_num'=>'ABCD12349'
        ]);
    }
}
