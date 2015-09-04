<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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

        DB::table('user')->insert([
            'username' => 'tester',
            'email'    => 'tester@tester.com',
            'password' => bcrypt('tester'),
        ]);

        Model::reguard();
    }
}
