<?php

namespace Tests\Browser\includes;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NavbarTest extends DuskTestCase
{
    /** @test */
    public function the_navbar_must_have_a_link_to_the_home_screen()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Home')
                ->clickLink('Home')
                ->assertPathIs('/');
        });
    }

    /** @test */
    public function the_navbar_must_have_a_link_to_the_about_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('About')
                ->clickLink('About')
                ->assertPathIs('/about');
        });
    }

    /** @test */
    public function the_navbar_must_have_a_link_to_the_contact_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Contact')
                ->clickLink('Contact')
                ->assertPathIs('/contact');
        });
    }

    /** @test */
    public function the_navbar_must_have_a_link_to_the_login_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Login')
                ->clickLink('Login')
                ->assertPathIs('/login');
        });
    }

    /** @test */
    public function the_navbar_must_have_a_link_to_the_shopping_cart()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Login')
                ->clickLink('Login')
                ->assertPathIs('/login');
        });
    }

    /** @test */
    public function if_the_user_clicks_on_the_shopping_cart_then_a_screen_should_open()
    {

    }
}
