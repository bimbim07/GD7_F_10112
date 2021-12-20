<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //GD11
        DB::table('users')->insert([
            'name' => 'Bima',
            'email' => '10112@students.uajy.ac.id',
            'password' => '$2y$10$l4x/SAiJXDHR6f37FRg1pu267F4Xsd6Tc223mGzADaAFRp3IX7ryy',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
