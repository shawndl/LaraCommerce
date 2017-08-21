<?php

namespace Tests\Feature\integration\db\transformers;

use App\Library\Transformer\ShoppingCartTransformer;
use Illuminate\Support\Facades\Session;
use Syscover\ShoppingCart\Facades\CartProvider;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShoppingCartTransformerTest extends TestCase
{
    use DatabaseMigrations, \SetUpShoppingCartTrait, \SetUpProductsTrait;

    /**
     * @var array
     */
    protected $shoppingCartTransformer;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
        $this->setUpShoppingCart();
        $this->shoppingCartTransformer = ShoppingCartTransformer::transform();
    }

    /** @test */
    public function the_shopping_cart_transformer_must_return_the_total()
    {
        $this->assertArrayHasKey('total', $this->shoppingCartTransformer['information']);
        $this->assertEquals(number_format(CartProvider::instance()->total, 2),
            $this->shoppingCartTransformer['information']['total']);
    }

    /** @test */
    public function the_shopping_cart_transformer_must_return_the_sub_total()
    {
        $this->assertArrayHasKey('sub_total', $this->shoppingCartTransformer['information']);
        $this->assertEquals(number_format(CartProvider::instance()->subtotal, 2),
            $this->shoppingCartTransformer['information']['sub_total']);
    }

    /** @test */
    public function the_shopping_cart_transformer_must_return_the_taxes()
    {
        $this->assertArrayHasKey('taxes', $this->shoppingCartTransformer['information']);
        $this->assertEquals(number_format(CartProvider::instance()->taxAmount, 2),
            $this->shoppingCartTransformer['information']['taxes']);
    }

    /** @test */
    public function the_shopping_cart_transformer_must_return_the_count()
    {
        $this->assertCount(4, $this->shoppingCartTransformer['products']);
    }

    /** @test */
    public function the_array_must_return_the_product_id()
    {
        $this->assertArrayHasKey('id', $this->shoppingCartTransformer['products'][0]);
        $this->assertEquals($this->products[0]->id,
            $this->shoppingCartTransformer['products'][0]['id']);
    }

    /** @test */
    public function the_array_must_return_the_product_title()
    {
        $this->assertArrayHasKey('title', $this->shoppingCartTransformer['products'][0]);
        $this->assertEquals($this->products[0]->title,
            $this->shoppingCartTransformer['products'][0]['title']);
    }

    /** @test */
    public function the_array_must_return_the_product_price()
    {
        $this->assertArrayHasKey('price', $this->shoppingCartTransformer['products'][0]);
        $this->assertEquals(number_format($this->products[0]->price, 2),
            $this->shoppingCartTransformer['products'][0]['price']);
    }

    /** @test */
    public function the_array_must_return_the_product_weight()
    {
        $this->assertArrayHasKey('weight', $this->shoppingCartTransformer['products'][0]);
        $this->assertEquals($this->products[0]->weight,
            $this->shoppingCartTransformer['products'][0]['weight']);
    }

    /** @test */
    public function the_array_must_return_the_product_image()
    {
        $this->assertArrayHasKey('image', $this->shoppingCartTransformer['products'][0]);
        $this->assertEquals($this->products[0]->image->path,
            $this->shoppingCartTransformer['products'][0]['image']);
    }

    /** @test */
    public function the_array_must_return_the_product_total()
    {
        $this->assertArrayHasKey('total', $this->shoppingCartTransformer['products'][0]);
        $this->assertEquals(18.36,
            $this->shoppingCartTransformer['products'][0]['total']);
    }

    /** @test */
    public function the_array_must_return_the_product_taxes()
    {
        $this->assertArrayHasKey('taxes', $this->shoppingCartTransformer['products'][0]);
        $this->assertEquals(.36,
            $this->shoppingCartTransformer['products'][0]['taxes']);
    }
}
