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
    }
}
