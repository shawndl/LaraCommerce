<?php

namespace Tests\Feature\integration\db\transformers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderTransformerProductsTest extends AbstractTestOrderTransformer
{
    protected function setUp()
    {
        parent::setUp();
        $this->addProductsToOrder();
        $this->resetOrderTransformerSingle(false, false, true);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function if_the_products_parameter_is_set_to_true_then_it_will_include_the_products_information()
    {
        $this->assertArrayHasKey('products', $this->orderTransformerSingle['order']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function if_the_products_parameter_is_set_to_false_then_it_will_not_include_the_products_information()
    {
        $this->resetOrderTransformerSingle();
        $this->assertArrayNotHasKey('products', $this->orderTransformerSingle['order']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function the_products_array_must_return_all_products_related_to_the_order()
    {
        $this->assertCount(4, $this->orderTransformerSingle['order']['products']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function the_products_array_must_return_the_product_id()
    {
        $this->assertArrayHasKey('id', $this->orderTransformerSingle['order']['products'][0]);
        $this->assertEquals($this->products[0]->id, $this->orderTransformerSingle['order']['products'][0]['id']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function the_products_array_must_return_the_product_total()
    {
        $this->assertArrayHasKey('total', $this->orderTransformerSingle['order']['products'][0]);
        $this->assertEquals($this->products[0]->price, $this->orderTransformerSingle['order']['products'][0]['total']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function the_products_array_must_return_the_product_description()
    {
        $this->assertArrayHasKey('description', $this->orderTransformerSingle['order']['products'][0]);
        $this->assertEquals($this->products[0]->description, $this->orderTransformerSingle['order']['products'][0]['description']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function the_products_array_must_return_the_product_image()
    {
        $this->assertArrayHasKey('image', $this->orderTransformerSingle['order']['products'][0]);
        $this->assertEquals($this->products[0]->image->path, $this->orderTransformerSingle['order']['products'][0]['image']);
    }
}
