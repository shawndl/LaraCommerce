<?php
/*
|--------------------------------------------------------------------------
| SearchByCategoryTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to assist users in finding their products
|    As a user
|    I need search products by category
|
| Scenario:
|   Given: I am a user
|   And: I want search for all products in a category
|   When: when I search products\{category}
|   Then: I should see all products that match that category
*/
namespace Tests\Feature\acceptance\http\search\route\view;


use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class SearchByCategoryTest extends AbstractHttpTestClass
{
    use \SetUpProductsTrait;

    protected $getRoute = 'product/';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
        $this->addMoreProducts();
        $this->getRoute = $this->getRoute . $this->category->name;
        $this->setGetResponse();
    }

    /**
     *  @test
     *  @group search
     *  @group acceptance
     */
    public function it_must_return_the_search_view()
    {
        $this->getResponse->assertViewIs('ecommerce.search');
    }

    /**
     *  @test
     *  @group search
     *  @group acceptance
     */
    public function it_must_return_the_search_products()
    {
        $this->getResponse->assertViewHas('products');
    }

    /**
     *  @test
     *  @group search
     *  @group acceptance
     */
    public function it_must_return_all_the_products_in_the_category()
    {
        $products = $this->getResponse->original->getData()['products'];
        $dbProducts = $this->category->products()->get();
        $this->assertCount(4, $products);
        $this->assertCount(4, $dbProducts);
    }

    /**
     *  @test
     *  @group search
     *  @group acceptance
     */
    public function it_must_return_the_product_information_of_that_category()
    {
        $products = $this->getResponse->original->getData()['products'];
        $dbProducts = $this->category->products()->get()->toArray();
        $this->assertEquals($products->toArray()['data'][0]['id'], $dbProducts[0]['id']);
        $this->assertEquals($products->toArray()['data'][1]['id'], $dbProducts[1]['id']);
        $this->assertEquals($products->toArray()['data'][2]['id'], $dbProducts[2]['id']);
        $this->assertEquals($products->toArray()['data'][3]['id'], $dbProducts[3]['id']);
    }

    /**
     *  @test
     *  @group search
     *  @group acceptance
     */
    public function it_must_return_the_users_search()
    {
        $this->getResponse->assertViewHas('search', $this->category->name);
    }
}
