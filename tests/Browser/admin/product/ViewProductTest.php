<?php

namespace Tests\Browser\admin\product;

use App\Product;
use Tests\Browser\admin\AbstractDuskAdmin;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ViewProductTest extends AbstractDuskAdmin
{
    use DatabaseMigrations;

    /**
     * @test
     * @group product
     * @group admin
     */
    public function it_must_be_able_to_view_a_products_details()
    {
        $this->addProduct();
        $product = Product::first();
        $user = $this->addUser(true);
        $this->browse(function (Browser $browser) use ($product, $user){
            $browser->loginAs($user)
                ->visit('admin/products')
                ->assertSee('Products Page')
                ->pause(2000)
                ->click('#' . $product->title . '-id')
                ->pause(2000)
                ->assertSee('Price: $' . $product->price)
                ->assertSee('Category: ' . $product->category->name)
                ->assertSee($product->description);
        });
    }
}
