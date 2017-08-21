<?php
/*
|--------------------------------------------------------------------------
| SearchByScoutPostTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to assist users in finding their products
|    As a user
|    I need search for a product
|
| Scenario:
|   Given: I am a user
|   And: I want search books
|   When: when I post of SearchController@scout
|   Then: I should be redirect to the SearchController@show method
*/
namespace Tests\Feature\acceptance\http\search\route\view;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class SearchByScoutPostTest extends AbstractHttpTestClass
{
    use \SetUpProductsTrait;

    protected $postRoute = 'products';

    protected $post = ['search' => 'book'];

    protected function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
        $this->setPostResponse($this->post);
    }

    /**
     *  @test
     *  @group search
     *  @group acceptance
     */
    public function it_must_redirect_the_user_to_the_products_search_page()
    {
        $this->postResponse->assertRedirect('products/book');
    }
}
