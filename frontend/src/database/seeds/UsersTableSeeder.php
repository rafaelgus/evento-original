<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@eventooriginal.com',
            'password' => bcrypt('secret'),
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 1,
            'role_id' => 1,
        ]);
    }
}
