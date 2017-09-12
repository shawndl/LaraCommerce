<?php
/*
|--------------------------------------------------------------------------
| ShoppingCartGetTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order retrieve information about my shopping cart
|    As a user
|    I need to view my order before I pay
|
| Scenario:
|   Given: I am a user viewing my current order
|   When: I visit the shopping-cart/get
|   Then: I should get a json object about my cart
*/
namespace Tests\Feature\acceptance\http\shoppingcart;

use Syscover\ShoppingCart\Facades\CartProvider;
use Tests\Feature\acceptance\http\AbstractHttpTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShoppingCartGetTest extends AbstractHttpTestClass
{
    use \SetUpProductsTrait, \SetUpShoppingCartTrait;

    protected $getRoute = 'shopping-cart/get';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
        $this->setUpShoppingCart();
        $this->setGetResponseSession(['cart' => [
            'default' => CartProvider::instance()
        ]]);
    }

    /**
     * @group shopping_cart
     * @group acceptance
     * @test
     */
    public function it_must_return_a_variable_()
    {
        $this->getResponse->assertJsonStructure(['cart' => [
            'information' => ['sub_total', 'total', 'taxes', 'count'],
            'products' => [
                ['id', 'title', 'price', 'taxes', 'quantity', 'weight', 'image']
            ]
        ]]);
    }
}
