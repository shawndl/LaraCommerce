<?php
/*
|--------------------------------------------------------------------------
| ShoppingCartUpdateSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to assist users in updating their order
|    As a user
|    I need to change the quantity of an item in my shopping cart
|
| Scenario:
|   Given: I am a user and I have a cart
|   And: and I want to update the quantity of items in my cart
|   When: I post to shopping-cart/update
|   Then: the quantity should be updated
*/
namespace Tests\Feature\acceptance\http\shoppingcart;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class ShoppingCartUpdateSuccessTest extends AbstractHttpTestClass
{
    use \SetUpProductsTrait, \SetUpShoppingCartTrait;

    protected $postRoute = 'shopping-cart/update';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
        $this->setUpShoppingCart();
        $this->setPostResponse([
            'product' => $this->products[0]->id,
            'quantity' => 3
        ]);
    }


    /**
     * @group shopping_cart
     * @group acceptance
     * @test
     */
    public function the_products_quantity_must_be_updated()
    {
        $this->assertEquals(3, $this->getCartItems()->first()->quantity);
    }

    /**
     * @group shopping_cart
     * @group acceptance
     * @test
     */
    public function it_must_return_a_message_to_the_user()
    {
        $this->assertEquals('You have updated the quantity of book to 3',
            $this->postResponse->json()['message']);
    }

    /**
     * @group shopping_cart
     * @group acceptance
     * @test
     */
    public function it_must_return_the_new_shopping_cart()
    {
        $this->postResponse->assertJsonStructure(
            [
                'cart' => [
                    'information' => ['sub_total', 'total', 'taxes', 'count'],
                    'products' => [
                        ['id', 'title', 'price', 'taxes', 'quantity', 'weight', 'image']
                    ],
                ],
                'message'
            ]);
    }
}
