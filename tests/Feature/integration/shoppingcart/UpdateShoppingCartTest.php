<?php

namespace Tests\Feature\integration\shoppingcart;


use App\Library\ShoppingCart\ShoppingCartUpdate;
use Syscover\ShoppingCart\Facades\CartProvider;

class UpdateShoppingCartTest extends AbstractShoppingCart
{
    protected function setUp()
    {
        parent::setUp();
        $this->setUpShoppingCart();
        $this->shoppingCart = new ShoppingCartUpdate($this->products[0], CartProvider::instance());
    }

    /**
     * @group shoppingcart
     * @test
     */
    public function it_must_be_able_to_update_the_quantity()
    {
        //Original
        $quantity = $this->findFromShoppingCart($this->products[0]->id)->getQuantity();
        $this->assertEquals("1", $quantity);
        $this->updateQuantity();
        //Updated
        $quantity = $this->findFromShoppingCart($this->products[0]->id)->getQuantity();
        $this->assertEquals("7", $quantity);
    }

    /**
     * @group shoppingcart
     * @test
     */
    public function it_must_return_a_message_for_the_user()
    {
        $this->updateQuantity();
        $this->assertEquals('You have updated the quantity of book to 7', $this->message);
    }

    /**
     * updates the quantity and sets the message
     *
     * @return void
     */
    private function updateQuantity()
    {
        $this->shoppingCart->setQuantity(7);
        $this->message = $this->shoppingCart->getResult();
    }
}
