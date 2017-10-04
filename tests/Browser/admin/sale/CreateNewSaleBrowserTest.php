<?php

namespace Tests\Browser\admin\sale;

use Tests\Browser\admin\AbstractDuskAdmin;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateNewSaleBrowserTest extends AbstractDuskAdmin
{
    /**
     * @test
     * @group sales
     * @group admin
     */
    public function it_must_be_able_to_create_a_product()
    {
        $this->addProduct();
        $this->browse(function (Browser $browser) {
            $browser->visit('admin/products')
                ->assertSee('Products Page')
                ->pressAndWaitFor('Add Sale', ['seconds', 3])
                ->assertSee('Add a Sale')
                ->type('sale-start', '2017-09-20')
                ->type('sale-finish', '2017-09-27')
                ->select('sale-discount', '20%')
                ->click('#sale-submit')
                ->pause(2000)
                ->assertSeeIn('#modal-message', 'You have added a sale to the book product!');
            $this->assertDatabaseHas('sales', [
                'discount' => '.20'
            ]);
        });
    }
}
