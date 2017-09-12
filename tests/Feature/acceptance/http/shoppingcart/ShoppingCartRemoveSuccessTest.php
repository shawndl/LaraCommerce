<?php
/*
|--------------------------------------------------------------------------
| ShoppingCartRemoveSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to assist users in removing items from a cart
|    As a use
|    I need remove an item from the cart
|
| Scenario:
|   Given: I have 4 items in my cart
|   And: I want the first one removed
|   When: when I post to shopping-cart/remove with the product id
|   Then: the first item should be removed from the cart
*/
namespace Tests\Feature\acceptance\http\shoppingcart;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class ShoppingCartRemoveSuccessTest extends AbstractHttpTestClass
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
     * @group shopping_cart
     * @group acceptance
     * @test
     */
    public function a_product_must_be_removed_from_the_shopping_cart()
    {
        $cart = $this->getCartItems();
        $this->assertEquals(4, $cart->count());
        $this->setPost();
        $this->assertEquals(3, $cart->count());
    }

    /**
     * @group shopping_cart
     * @group acceptance
     * @test
     */
    public function it_must_be_the_correct_product()
    {
        $this->setPost();
        $cart = $this->getCartItems()->toArray();
        $searchResults = array_search($this->products[0]->id,
            array_column($cart, 'id'));
        $this->assertFalse($searchResults);
    }

    /**
     * @group shopping_cart
     * @group acceptance
     * @test
     */
    public function it_must_return_an_error_message()
    {
        $this->setPost();
        $this->postResponse->assertJsonFragment(['message' =>
            'You removed the book from your shopping cart']);
    }

    /**
     * @group shopping_cart
     * @group acceptance
     * @test
     */
    public function it_must_return_the_cart()
    {
        $this->setPost();
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

    private function setPost($post = 0)
    {
        $this->setPostResponse([
            'product' => $this->products[$post]->id
        ]);
    }
}
