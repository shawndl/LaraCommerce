<?php

namespace Tests\Feature\acceptance\admin\sale;

use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;

class ViewSaleSuccessTest extends AbstractHttpAjaxTestClass
{
    use \SetUpSaleTrait;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpSale();
        $this->getRoute = 'admin/products/sales/' . $this->sale->id;
        $this->setGetResponseAdmin();
    }

    /**
     * @group sales
     * @group admin
     * @group acceptance
     * @test
     */
    public function it_must_return_the_sale_details()
    {
        $this->getResponse->assertJsonStructure([
            "sale" => [
                "id", "product_title", "product_description", "category", "product_price",
                "product_image", "discount", "discount_price", "sale_start", "sale_finish"
            ]
        ]);
    }
}
