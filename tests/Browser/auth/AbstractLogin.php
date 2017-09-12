<?php

namespace Tests\Browser\auth;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AbstractLogin extends DuskTestCase
{
    /**
     * sets up a user in the database
     *
     * @return void
     */
    protected function setUpUser()
    {
        factory(User::class)->create([
            'email' => 'email@company.com',
            'username' => 'coffee',
            'password' => bcrypt('secret')
        ]);
    }
}
