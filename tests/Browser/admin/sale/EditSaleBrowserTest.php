<?php
/*
|--------------------------------------------------------------------------
| EditSaleBrowserTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to keep sales current
|    As an admin
|    I need update a sale
|
| Scenario:
|   Given: I am administrator who wants to update a product
|   And: I am on the products admin page
|   When: click the edit sale button a form should appear. When I submit
|   Then: The sale should be updated in the database
*/
namespace Tests\Browser\admin\sale;

use Tests\Browser\admin\AbstractDuskAdmin;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditSaleBrowserTest extends AbstractDuskAdmin
{
    /**
     * @test
     * @group sales
     * @group admin
     */
    public function it_must_be_able_to_update_a_product()
    {
        $this->addSale();
        $this->browse(function (Browser $browser) {
            $browser->visit('admin/products')
                ->assertSee('Products Page')
                ->pause(1000)
                ->pressAndWaitFor('Edit Sale', ['seconds', 3])
                ->assertSee('Edit this Sale')
                ->select('sale-discount', '0.30')
                ->click('#sale-submit')
                ->pause(2000)
                ->assertSeeIn('#modal-message', 'You updated a sale!');
        });
        $this->assertDatabaseHas('sales', [
            'discount' => '.30'
        ]);
    }
}
