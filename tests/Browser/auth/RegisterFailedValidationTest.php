<?php

namespace Tests\Browser\auth;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterFailedValidationTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @group auth
     * @test
     */
    public function the_first_name_is_required()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('email', 'jack@gmail.com')
                ->type('first_name', '')
                ->press('Register')
                ->assertPathIs('/register')
                ->assertSeeIn('#first-name-error', 'The first_name field is required.');
        });
        $this->assertDatabaseMissing('users', [
            'email' => 'jack@gmail.com'
        ]);
    }

    /**
     * @group auth
     * @test
     */
    public function the_first_name_must_be_only_letters_and_spaces()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('email', 'jack@gmail.com')
                ->type('first_name', "<?php echo='attack' ?>")
                ->press('Register')
                ->assertPathIs('/register')
                ->assertSeeIn('#first-name-error', 'The first_name field may only contain alphabetic characters as well as spaces.');
        });
        $this->assertDatabaseMissing('users', [
            'email' => 'jack@gmail.com'
        ]);
    }

    /** @test */
    public function the_last_name_is_required()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('email', 'jack@gmail.com')
                ->type('last_name', '')
                ->press('Register')
                ->assertPathIs('/register')
                ->assertSeeIn('#last-name-error', 'The last_name field is required.');
        });
        $this->assertDatabaseMissing('users', [
            'email' => 'jack@gmail.com'
        ]);
    }

    /** @test */
    public function the_last_name_must_be_only_letters_and_spaces()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('email', 'jack@gmail.com')
                ->type('last_name', "<script>alert('attack')</script>")
                ->press('Register')
                ->assertPathIs('/register')
                ->assertSeeIn('#last-name-error', 'The last_name field may only contain alphabetic characters as well as spaces.');
        });
        $this->assertDatabaseMissing('users', [
            'email' => 'jack@gmail.com'
        ]);
    }

    /** @test */
    public function the_email_is_required()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('first_name', 'Jack')
                ->type('email', '')
                ->press('Register')
                ->assertPathIs('/register')
                ->assertSeeIn('#email-error', 'The email field is required.');
        });
        $this->assertDatabaseMissing('users', [
            'first_name' => 'Jack'
        ]);
    }

    /** @test */
    public function the_email_must_an_email()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('email', 'jack')
                ->type('first_name', 'Jack')
                ->press('Register')
                ->assertPathIs('/register')
                ->assertSeeIn('#email-error', 'The email field must be a valid email.');
        });
        $this->assertDatabaseMissing('users', [
            'first_name' => 'Jack'
        ]);
    }


    /** @test */
    public function the_username_is_required()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('email', 'jack@gmail.com')
                ->type('username', '')
                ->press('Register')
                ->assertPathIs('/register')
                ->assertSeeIn('#username-error', 'The username field is required.');
        });
        $this->assertDatabaseMissing('users', [
            'email' => 'jack@gmail.com'
        ]);
    }

    /** @test */
    public function the_username_must_only_contain_letters_and_spaces()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('email', 'jack@gmail.com')
                ->type('username', '<script>alert("attack")</script>')
                ->press('Register')
                ->assertPathIs('/register')
                ->assertSeeIn('#username-error', 'The username field may only contain alphabetic characters as well as spaces.');
        });
        $this->assertDatabaseMissing('users', [
            'email' => 'jack@gmail.com'
        ]);
    }
    
    /** @test */
    public function the_password_is_required()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('email', 'jack@gmail.com')
                ->type('password', '')
                ->press('Register')
                ->assertPathIs('/register')
                ->assertSeeIn('#password-error', 'The password field is required');
        });
        $this->assertDatabaseMissing('users', [
            'email' => 'jack@gmail.com'
        ]);
    }


    /** @test */
    public function the_password_must_be_5_characters_or_more()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('email', 'jack@gmail.com')
                ->type('password', 'pass')
                ->press('Register')
                ->assertPathIs('/register')
                ->assertSeeIn('#password-error', 'The password field must be at least 5 characters.');
        });
        $this->assertDatabaseMissing('users', [
            'email' => 'jack@gmail.com'
        ]);
    }

    /** @test */
    public function the_password_and_password_confirmation_must_match()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('email', 'jack@gmail.com')
                ->type('password', 'secret')
                ->type('password_confirmation', 'password')
                ->press('Register')
                ->assertPathIs('/register')
                ->assertSeeIn('#password-error', 'The password confirmation does not match.');
        });
        $this->assertDatabaseMissing('users', [
            'email' => 'jack@gmail.com'
        ]);
    }
}
