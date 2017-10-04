<?php

namespace Tests\Browser\admin\product;

use App\Product;
use Tests\Browser\admin\AbstractDuskAdmin;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteProductTest extends AbstractDuskAdmin
{
    use DatabaseMigrations;

    /**
     * @test
     * @group product
     * @group admin
     */
    public function it_must_be_able_to_delete_a_product()
    {
        $this->addProduct();
        $this->browse(function (Browser $browser) {
            $browser->visit('admin/products')
                ->assertSee('Products Page')
                ->pressAndWaitFor('Delete', ['seconds' => 2])
                ->assertSee('Delete book')
                ->press('OK')
                ->pause(2000)
                ->assertSeeIn('#modal-message', 'You deleted the book product!');
            $this->assertDatabaseMissing('products', [
                'title' => 'book'
            ]);
        });
    }
}
