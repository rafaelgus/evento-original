<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'admin'
        ]);

        DB::table('roles')->insert([
            'name' => 'customer'
        ]);

        DB::table('roles')->insert([
            'name' => 'seller'
        ]);

        DB::table('roles')->insert([
            'name' => 'designer'
        ]);
    }
}
