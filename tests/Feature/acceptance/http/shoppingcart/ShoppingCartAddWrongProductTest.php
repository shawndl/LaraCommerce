<?php
/*
|--------------------------------------------------------------------------
| ShoppingCartAddWrongProductTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to inform users that there was an error adding an item to the cart
|    As a user
|    I need to add a product to the cart
|
| Scenario:
|   Given: a user tries to add an item to the cart that does not exist
|   When: I post to shopping-cart/add
|   Then: an error message should be returned
*/
namespace Tests\Feature\acceptance\http\shoppingcart;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class ShoppingCartAddWrongProductTest extends AbstractHttpTestClass
{
    use \SetUpProductsTrait, \SetUpShoppingCartTrait;

    protected $postRoute = 'shopping-cart/add';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
        $this->setPostResponse([
            'product' => 55,
            'quantity' => 3
        ]);
    }

    /**
     * @group shoppingcart
     * @group acceptance
     * @test
     */
    public function a_product_must_not_be_added_to_the_cart()
    {
        $this->assertEquals(0, $this->getCartItems()->count());
    }

    /**
     * @group shoppingcart
     * @group acceptance
     * @test
     */
    public function an_error_message_must_be_returned_to_the_user()
    {
        $this->postResponse->assertJson(['error' =>
            'Sorry there was an error adding to your cart.  Please try again']);
    }
}
