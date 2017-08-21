<?php
/*
|--------------------------------------------------------------------------
| ShoppingCartRemoveErrorTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to inform users when there was a processing error
|    As a user
|    I need remove an item from the cart but there is a processing error
|
| Scenario:
|   Given: I have 4 items in my cart
|   And: I there is a processing error
|   When: when I post to shopping-cart/remove with the product id
|   Then: an error message must be returned to the user
*/

namespace Tests\Feature\acceptance\http\shoppingcart;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class ShoppingCartRemoveErrorTest extends AbstractHttpTestClass
{
    use \SetUpShoppingCartTrait, \SetUpProductsTrait;

    protected $postRoute = 'shopping-cart/remove';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
        $this->setUpShoppingCart();
    }

    /**
     * @group shoppingcart
     * @group acceptance
     * @test
     */
    public function a_product_must_not_be_removed_from_the_shopping_cart()
    {
        $cart = $this->getCartItems();
        $this->assertEquals(4, $cart->count());
        $this->setPost();
        $this->assertEquals(4, $cart->count());
    }

    /**
     * @group shoppingcart
     * @group acceptance
     * @test
     */
    public function it_must_return_an_error_message()
    {
        $this->setPost();
        $this->postResponse->assertJson(['error' =>
            'Sorry there was an error removing an item from your cart.  Please try again']);
    }

    private function setPost()
    {
        $this->setPostResponse([
            'product' => 22
        ]);
    }
}
