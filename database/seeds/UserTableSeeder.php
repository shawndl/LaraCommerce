<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory('App\User', 50)->create();
        $users = \App\Library\Data\FetchJsonFile::open('users.json');
        foreach ($users as $user)
        {
            \App\User::create([
                'username' => $user['first_name'] . $user['last_name'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'phone' => $user['phone'],
                'email' => $user['email'],
                'password' => bcrypt($user['password'])
            ]);
        }
    }
}
