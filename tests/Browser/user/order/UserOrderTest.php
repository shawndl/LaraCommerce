<?php

namespace Tests\Browser\user\order;

use Tests\Browser\AbstractBrowser;
use Laravel\Dusk\Browser;

class UserOrderTest extends AbstractBrowser
{
    /**
     * @group user
     * @group order
     * @test
     */
    public function it_must_not_allow_a_user_to_view_the_order_page_if_they_are_not_signed_in()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('order/edit-order')
                ->assertPathIs('/login');
        });
    }
}
