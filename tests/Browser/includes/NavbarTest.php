<?php

namespace Tests\Browser\includes;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class NavbarTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @group includes
     */
    public function the_navbar_must_have_a_link_to_the_home_screen()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Home')
                ->clickLink('Home')
                ->assertPathIs('/');
        });
    }

    /**
     * @test
     * @group includes
     */
    public function the_navbar_must_have_a_link_to_the_about_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('About')
                ->clickLink('About')
                ->assertPathIs('/about');
        });
    }

    /**
     * @test
     * @group includes
     */
    public function the_navbar_must_have_a_link_to_the_contact_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Contact')
                ->clickLink('Contact')
                ->assertPathIs('/contact');
        });
    }

    /**
     * @test
     * @group includes
     */
    public function the_navbar_must_have_a_link_to_the_login_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Login')
                ->clickLink('Login')
                ->assertPathIs('/login');
        });
    }


    /**
     * @test
     * @group includes
     */
    public function the_navbar_must_have_a_link_to_the_registration_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Register')
                ->clickLink('Register')
                ->assertPathIs('/register');
        });
    }

    /**
     * @test
     * @group includes
     */
    public function the_navbar_must_have_a_link_to_the_shopping_cart_which_opens_a_drop_down_when_clicked()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertVisible('#shopping-cart')
                ->click('#shopping-cart')
                ->assertSee('0 Items with total of $0.00')
                ->assertSee('Check Out')
                ->clickLink('Check Out');
            $browser->pause(2000)
                ->assertPathIs('/login');
        });
    }
}
