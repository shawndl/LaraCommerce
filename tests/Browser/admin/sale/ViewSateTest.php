<?php

namespace Tests\Browser\admin\sale;

use App\Sale;
use Tests\Browser\admin\AbstractDuskAdmin;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ViewSateTest extends AbstractDuskAdmin
{
    use DatabaseMigrations;

    /**
     * @test
     * @group sales
     * @group admin
     */
    public function it_must_be_able_to_view_a_products_details()
    {
        $this->addSale();
        $sale = Sale::first();
        $this->browse(function (Browser $browser) use ($sale) {
            $browser->visit('admin/products')
                ->assertSee('Products Page')
                ->pause(2000)
                ->press('View Sale')
                ->pause(2000)
                ->assertSee('View Sale on ' . $sale->product->title)
                ->assertSee('Discount: %25')
                ->assertSee('Sale Start Date:')
                ->assertSee('Sale Finish Date:')
                ->assertSee('Price:')
                ->assertSee('Discount Price:');
        });
    }
}
