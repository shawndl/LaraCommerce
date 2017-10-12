<?php

namespace Tests\Feature\acceptance\admin\product;

use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;

class DeleteProductFailAuthTest extends AbstractHttpAjaxTestClass
{
    use \SetUpProductsTrait;
    /**
     * @var string
     */
    protected $postRoute = 'admin/products';

    /**
     * @var string
     */
    protected $productName;

    public function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
        $this->postRoute = $this->postRoute . '/' . $this->products[0]->id;
        $this->productName = $this->products[0]->title;
        $this->setPostResponse(['_method' => 'DELETE']);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function it_must_return_a_401()
    {
        $this->postResponse->assertStatus(401);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_product_must_not_be_deleted()
    {
        $this->assertDatabaseHas('products', [
            'title' => $this->productName
        ]);
    }
}
