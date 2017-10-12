<?php

namespace Tests\Browser\user\home;

use Tests\Browser\AbstractBrowser;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class HomePageTest extends AbstractBrowser
{
    use DatabaseMigrations;

    /**
     * @group homepage
     * @test
     */
    public function the_home_page_must_display_product_information()
    {
        $product = $this->addProduct();
        $this->browse(function (Browser $browser) use ($product){
            $browser->visit('/')
                    ->assertSee('Lara-Commerce')
                    ->assertSee($product->title)
                    ->assertSee($product->price)
                    ->assertSee($product->description);
        });
    }

    /**
     * @group homepage
     * @test
     */
    public function the_home_page_must_display_sales()
    {
        $sale = $this->addSale();
        $this->browse(function (Browser $browser) use ($sale){
            $browser->visit('/')
                ->assertSee('Lara-Commerce')
                ->assertSee($sale->product->title)
                ->assertSee($sale->product->price)
                ->assertSee($sale->product->description)
                ->assertSee($sale->product->salePrice());
        });
    }
}
