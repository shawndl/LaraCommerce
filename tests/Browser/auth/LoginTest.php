<?php

namespace Tests\Browser\auth;

use App\User;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends AbstractLogin
{
    use DatabaseMigrations;

    /**
     * @group auth
     * @test
     */
    public function a_user_must_be_able_to_login_if_they_enter_the_correct_password()
    {
        $this->setUpUser();
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'email@company.com')
                ->type('password', 'secret')
                ->press('Login')
                ->assertPathIs('/')
                ->assertSee("coffee's Account")
                ->click('#user-account')
                ->assertSee('My Account')
                ->assertSee('Logout');
        });
    }
}
