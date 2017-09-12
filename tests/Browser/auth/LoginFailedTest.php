<?php

namespace Tests\Browser\auth;


use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginFailedTest extends LoginTest
{
    use DatabaseMigrations;

    /**
     * @group auth
     * @test
     */
    public function a_user_must_not_be_able_to_login_if_they_enter_the_wrong_password()
    {
        $this->setUpUser();
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'email@company.com')
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/login')
                ->assertSee('These credentials do not match our records.');
        });
    }

    /**
     * @group auth
     * @test
     */
    public function a_user_must_not_be_able_to_login_if_they_enter_the_wrong_email()
    {
        $this->setUpUser();
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'other@company.com')
                ->type('password', 'secret')
                ->press('Login')
                ->assertPathIs('/login')
                ->assertSee('These credentials do not match our records.');
        });
    }
}
