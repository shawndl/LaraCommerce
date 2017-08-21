<?php
/*
|--------------------------------------------------------------------------
| SearchByScoutGetTest.php
|--------------------------------------------------------------------------
| Feature:
|    In order to assist users in finding their products
|    As a user
|    I need search for a product
|
| Scenario:
|   Given: I am a user
|   And: I want search books
|   When: when I visit 'products/book'
|   Then: I should see search results for books
*/

namespace Tests\Feature\acceptance\http\search\route\view;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchByScoutGetTest extends AbstractHttpTestClass
{
    use \SetUpProductsTrait;

    protected $getRoute = 'products/book';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
    }

    /**
     *  @test
     *  @group search
     *  @group acceptance
     */
    public function it_must_return_the_ecommerce_search_view()
    {
        $this->getResponse->assertViewIs('ecommerce.search');
    }

    /**
     *  @test
     *  @group search
     *  @group acceptance
     */
    public function it_must_return_the_products()
    {
        $this->getResponse->assertViewHas('products');
    }

    /**
     *  @test
     *  @group search
     *  @group acceptance
     */
    public function it_must_return_the_users_search()
    {
        $this->getResponse->assertViewHas('search', 'book');
    }
}
