<?php

namespace Tests\Feature\integration\shoppingcart;

use App\Library\ShoppingCart\ShoppingCartRemove;
use Syscover\ShoppingCart\Facades\CartProvider;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RemoveItemShoppingCartTest extends AbstractShoppingCart
{
    protected function setUp()
    {
        parent::setUp();
        $this->setUpShoppingCart();
        $this->shoppingCart = new ShoppingCartRemove($this->products[0], CartProvider::instance());

    }
    
    /**
     * @group shoppingcart
     * @test
     */
    public function it_must_be_able_to_remove_an_item_from_the_shopping_cart()
    {
        $this->assertEquals(4, CartProvider::instance()->getCartItems()->count());
        $this->shoppingCart->getResult();
        $this->assertEquals(3, CartProvider::instance()->getCartItems()->count());
    }
    
    /**
     * @group shoppingcart
     * @test
     */
    public function it_must_return_a_message_to_the_user()
    {
        $this->message = $this->shoppingCart->getResult();
        $this->assertEquals('You removed the book from your shopping cart', $this->message);
    }
}
