<?php

namespace Tests\Browser\user\home;

use Tests\Browser\AbstractBrowser;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ContactPageTest extends AbstractBrowser
{
    /**
     * @group homepage
     * @test
     */
    public function the_contact_page_must_display_contact_information()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                ->assertSee('Lara-Commerce')
                ->assertSee('Customer Service')
                ->assertSee('customer.service')
                ->assertSee('Tech Support');
        });
    }
}
