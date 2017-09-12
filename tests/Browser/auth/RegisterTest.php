<?php

namespace Tests\Browser\auth;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    /**
     * @group auth
     * @test
     */
    public function it_must_be_able_to_register_new_user()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('first_name', 'Jack')
                ->type('last_name', 'Smith')
                ->type('username', 'newguy')
                ->type('email', 'jack@gmail.com')
                ->type('password', 'secret')
                ->type('password_confirmation', 'secret')
                ->press('Register')
                ->waitForLocation('/')
                ->assertPathIs('/')
                ->assertSee("newguy's Account");
        });
        $this->assertDatabaseHas('users', [
           'email' => 'jack@gmail.com'
        ]);
    }
}
