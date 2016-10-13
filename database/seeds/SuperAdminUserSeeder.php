<?php

use Illuminate\Database\Seeder;

class SuperAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\User::create([
            'email'=> 'shamail.siddiqui@cars2let.com',
            'password'=> bcrypt('alizoya1'),
            'status'=>'active',
            'type'=>'super-admin'
        ]);
        \App\User::create([
            'email'=> 'alpha@cars2let.com',
            'password'=> bcrypt('1234'),
            'status'=>'active',
            'type'=>'investor'
        ]);
        \App\User::create([
            'email' => 'admin@cars2let.com',
            'password' => bcrypt('1234'),
            'status' => 'active',
            'type' => 'admin'
        ]);
        \App\User::create([
            'email' => 'admin2@cars2let.com',
            'password' => bcrypt('1234'),
            'status' => 'active',
            'type' => 'admin'
        ]);
    }
}
