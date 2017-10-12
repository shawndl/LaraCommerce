<?php

namespace Tests\Browser\user\home;

use Tests\Browser\AbstractBrowser;
use Laravel\Dusk\Browser;

class AboutPageTest extends AbstractBrowser
{
    /**
     * @group homepage
     * @test
     */
    public function the_about_page_must_display_contact_information()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/about')
                ->assertSee('Lara-Commerce')
                ->assertSee('About Us');
        });
    }
}
