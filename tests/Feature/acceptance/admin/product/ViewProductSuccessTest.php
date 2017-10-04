<?php

namespace Tests\Feature\acceptance\admin\product;

use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewProductSuccessTest extends AbstractHttpAjaxTestClass
{
    use \SetUpProductsTrait;

    protected $getRoute = 'admin/products-api/';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
        $this->getRoute = 'admin/products/' . $this->products[0]->id;
        $this->setGetResponseAdmin();
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function it_must_return_details_about_the_product()
    {
        $this->getResponse->assertJsonStructure([
           'product' => [
               'product_id', 'title', 'price', 'description', 'weight', 'category', 'image'
           ]
        ]);
    }
}
