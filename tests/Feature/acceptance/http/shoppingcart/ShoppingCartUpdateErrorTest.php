<?php
/*
|--------------------------------------------------------------------------
| ShoppingCartUpdateErrorTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to inform users that there was an error adding an item to the cart
|    As a user
|    I need to update a product to the cart but there is an error
|
| Scenario:
|   Given: a user tries to update an item in my cart
|   And: there is a processing error
|   When: I post to shopping-cart/add
|   Then: an error message should be returned
*/
namespace Tests\Feature\acceptance\http\shoppingcart;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class ShoppingCartUpdateErrorTest extends AbstractHttpTestClass
{
    use \SetUpProductsTrait, \SetUpShoppingCartTrait;

    protected $postRoute = 'shopping-cart/update';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
        $this->setPostResponse([
            'product' => 1,
            'quantity' => 3
        ]);
    }

    /**
     * @group shopping_cart
     * @group acceptance
     * @test
     */
    public function an_error_message_must_be_returned_to_the_user()
    {
        $this->postResponse->assertJson(['error' =>
            'Sorry there was an error updating your cart.  Please try again']);
    }
}
