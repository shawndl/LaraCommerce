<?php

namespace Tests\Feature\integration\shoppingcart;

use App\Library\ShoppingCart\ShoppingCartAdd;
use App\Library\ShoppingCart\ShoppingCartInterface;
use Syscover\ShoppingCart\Facades\CartProvider;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddToShoppingCartTest extends AbstractShoppingCart
{
    use DatabaseTransactions, \SetUpProductsTrait;

    protected function setUp()
    {
        parent::setUp();
        $this->shoppingCart = new ShoppingCartAdd($this->products[0], CartProvider::instance());
        $this->shoppingCart->setQuantity(5);
        $this->message = $this->shoppingCart->getResult();
    }

    /**
     * @group shoppingcart
     * @test
     */
    public function it_must_be_able_to_add_a_product_to_the_shopping_cart()
    {
        $this->assertEquals(1, CartProvider::instance()->getCartItems()->count());
    }

    /**
     * @group shoppingcart
     * @test
     */
    public function it_must_be_able_to_set_the_quantity_of_the_item()
    {
        $this->assertEquals(5, CartProvider::instance()->getCartItems()->first()->quantity);
    }

    /**
     * @group shoppingcart
     * @test
     */
    public function it_must_return_a_user_message()
    {
        $this->assertEquals('You added book to your cart!', $this->message);
    }

    /**
     * @group shoppingcart
     * @test
     */
    public function it_must_find_the_tax_related_to_the_product()
    {
        $tax = CartProvider::instance()->getCartItems()->first()->taxRules;
        $rate = $this->products[0]->tax()->first()->percent * 100;
        $this->assertEquals($rate, $tax->first()->taxRate);
    }
}
