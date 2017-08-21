<?php
/*
|--------------------------------------------------------------------------
| ViewProductSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to assist users in viewing a product details
|    As a user
|    I need view a product
|
| Scenario:
|   Given: I am a user
|   When: I click on a link that visits view-product/{title}
|   Then: I must be able to see the products information
*/
namespace Tests\Feature\acceptance\http\products;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewProductSuccessTest extends AbstractHttpTestClass
{
    use \SetUpProductsTrait;
    protected $getRoute;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
        $this->getRoute = 'view-product/' . $this->products[0]->title;
        $this->setGetResponse();
    }

    /**
     * @group payment
     * @group acceptance
     * @test
     */
    public function it_must_return_a_status_of_200()
    {
        $this->getResponse->assertStatus(200);
    }

    /**
     * @group payment
     * @group acceptance
     * @test
     */
    public function it_must_have_a_products_variable()
    {
        $this->getResponse->assertViewHas('product');
    }

    /**
     * @group payment
     * @group acceptance
     * @test
     */
    public function the_product_variable_must_have_information_about_the_product()
    {
        $product = $this->getResponse->original->getData()['product'];
        $this->assertEquals($this->products[0]->id, $product['id']);
        $this->assertEquals($this->products[0]->title, $product['title']);
        $this->assertEquals($this->products[0]->price, $product['price']);
        $this->assertEquals($this->products[0]->description, $product['description']);
        $this->assertEquals($this->products[0]->image->first()->path, $product['image']['path']);
    }
}
