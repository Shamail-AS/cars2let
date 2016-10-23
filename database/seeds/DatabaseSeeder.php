<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        //$this->call(InvestorsTableSeeder::class);
        $this->call(SuperAdminUserSeeder::class);
        //$this->call(CarTableSeeder::class);
        //$this->call(ContractsTableSeeder::class);
        //$this->call(RevenuesTableSeeder::class);
        //$this->call(DriverTableSeeder::class);

        Model::reguard();
    }
}
