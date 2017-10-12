<?php
/*
|--------------------------------------------------------------------------
| SearchByScoutAjaxRequestTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to provide a live search
|    As a user
|    I want to see live search results when I type
|
| Scenario:
|   Given: I am a user who types a search
|   When: an ajax post is sent to products/api
|   Then: search results for that product should be returned
*/
namespace Tests\Feature\acceptance\http\search\route\ajax;

use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchByScoutAjaxRequestTest extends AbstractHttpAjaxTestClass
{
    use \SetUpProductsTrait;

    protected $postRoute = 'products/api';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
        $this->setPostResponse([
            'search' => 'book'
        ]);
    }

    /**
     * @test
     * @group search
     * @group acceptance
     */
    public function it_must_return_status_200()
    {
        $this->postResponse->assertStatus(200);
    }

    /**
     * @test
     * @group search
     * @group acceptance
     */
    public function it_must_return_the_products()
    {
        $this->postResponse->assertJsonFragment([
            "products" => [
                [
                    "product_id" => 1,
                    "title" => "book",
                    "price" => "18.00",
                    "description" => "A cool book",
                    "weight" => "14.29",
                    "category" => "Clothes",
                    "image" => "http://lorempixel.com/400/200",
                    "thumbnail" => null
                ],
                [
                    "product_id" => 2,
                    "title" => "notebook",
                    "price" => "21.94",
                    "description" => "Another cool book",
                    "weight" => "13.29",
                    "category" => "Clothes",
                    "image" => "http://lorempixel.com/400/200",
                    "thumbnail" => null
                ]
            ],
            "search" => "book"
        ]);
    }
}
