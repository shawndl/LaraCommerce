<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name' => 'admin'
        ]);
        $user = \App\User::create([
           'username'  => 'admin',
            'email' => 'admin@test.com',
            'first_name' => 'admin',
            'last_name' => 'user',
            'phone' => '12392901',
            'password' => bcrypt('secret')
        ]);
        $user->roles()->attach($admin->id);
    }
}
