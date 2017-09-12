<?php

namespace Tests\Browser\auth;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginFailedValidationTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @group auth
     * @test
     */
    public function the_email_is_required()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', '')
                ->type('password', 'secret')
                ->press('Login')
                ->assertPathIs('/login')
                ->assertSeeIn('#email-error', 'The email field is required');
        });
    }

    /**
     * @group auth
     * @test
     */
    public function the_email_must_be_an_email()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'email')
                ->type('password', 'secret')
                ->press('Login')
                ->assertPathIs('/login')
                ->assertSeeIn('#email-error', 'The email field must be a valid email.');
        });
    }

    /**
     * @group auth
     * @test
     */
    public function the_password_is_required()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'jack@gmail.com')
                ->type('password', '')
                ->press('Login')
                ->assertPathIs('/login')
                ->assertSeeIn('#password-error', 'The password field is required');
        });
    }
}
