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

        DB::table('blog')->insert([
            'title'   => 'Test blog title',
            'content' => 'Test blog content.',
            'user_id' => 1,
        ]);

        Model::reguard();
    }
}
