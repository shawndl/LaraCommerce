<?php
/*
|--------------------------------------------------------------------------
| ShoppingCartAddSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to allow users to add to their cart
|    As a user
|    I need to add a product to my cart
|
| Scenario:
|   Given: I am a user
|   When: I post a product and a quantity to shopping-cart/add
|   Then: A that product will be added to my database
*/
namespace Tests\Feature\acceptance\http\shoppingcart;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShoppingCartAddSuccessTest extends AbstractHttpTestClass
{
    use \SetUpProductsTrait, \SetUpShoppingCartTrait;

    protected $postRoute = 'shopping-cart/add';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
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
    public function a_product_must_be_added_to_the_cart()
    {
        $this->assertEquals(1, $this->getCartItems()->count());
    }

    /**
     * @group shopping_cart
     * @group acceptance
     * @test
     */
    public function it_must_be_the_correct_product()
    {
        $this->assertEquals($this->getCartItems()->first()->name,
            $this->products[0]->title);
    }

    /**
     * @group shopping_cart
     * @group acceptance
     * @test
     */
    public function it_must_be_the_correct_quantity()
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
        $this->assertEquals('You added book to your cart!',
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
