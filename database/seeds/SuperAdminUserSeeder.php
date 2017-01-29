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
            'password' => bcrypt('No1No2No3'),
            'status'=>'active',
            'type'=>'super-admin'
        ]);
        \App\User::create([
            'email' => 'alpha@cars2let.com',
            'password' => bcrypt('demo'),
            'status' => 'active',
            'type' => 'investor'
        ]);
        \App\User::create([
            'email' => 'admin@cars2let.com',
            'password' => bcrypt('demo'),
            'status' => 'active',
            'type' => 'admin'
        ]);
        \App\User::create([
            'email' => 'super-admin@cars2let.com',
            'password' => bcrypt('demo'),
            'status' => 'active',
            'type' => 'super-admin'
        ]);
    }
}
