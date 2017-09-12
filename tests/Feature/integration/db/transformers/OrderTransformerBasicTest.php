<?php

namespace Tests\Feature\integration\db\transformers;

use App\Library\Transformer\OrderTransformers;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderTransformerBasicTest extends AbstractTestOrderTransformer
{
    protected function setUp()
    {
        parent::setUp();
        $this->resetOrderTransformerSingle();
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function it_must_return_the_order_id()
    {
        $this->assertArrayHasKey('id', $this->orderTransformerSingle['order']);
        $this->assertEquals($this->orders[0]->id, $this->orderTransformerSingle['order']['id']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function it_must_return_if_the_order_was_created()
    {
        $this->assertArrayHasKey('created', $this->orderTransformerSingle['order']);
        $this->assertTrue($this->orderTransformerSingle['order']['created']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function it_must_return_the_estimated_arrival_date()
    {
        $this->assertArrayHasKey('arrival', $this->orderTransformerSingle['order']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function it_must_return_the_order_date()
    {
        $this->assertArrayHasKey('order_date', $this->orderTransformerSingle['order']);
        $this->assertEquals($this->orders[0]->formatOrderDate(), $this->orderTransformerSingle['order']['order_date']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function if_the_ship_date_is_set_then_it_must_return_the_ship_date()
    {
        $this->assertArrayHasKey('ship_date', $this->orderTransformerSingle['order']);
        $this->assertEquals($this->orders[0]->formatShipDate(), $this->orderTransformerSingle['order']['ship_date']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function if_the_ship_date_is_not_set_then_it_must_return_false()
    {
        $transformer = OrderTransformers::single($this->orders[1]);
        $this->assertFalse($transformer['order']['ship_date']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function it_must_return_the_order_total()
    {
        $this->assertArrayHasKey('total', $this->orderTransformerSingle['order']['cost']);
        $this->assertEquals(18.45, $this->orderTransformerSingle['order']['cost']['total']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function it_must_return_the_order_subtotal()
    {
        $this->assertArrayHasKey('sub_total', $this->orderTransformerSingle['order']['cost']);
        $this->assertEquals(16.45, $this->orderTransformerSingle['order']['cost']['sub_total']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function it_must_return_the_order_taxes()
    {
        $this->assertArrayHasKey('taxes', $this->orderTransformerSingle['order']['cost']);
        $this->assertEquals(2.00, $this->orderTransformerSingle['order']['cost']['taxes']);
    }

}
