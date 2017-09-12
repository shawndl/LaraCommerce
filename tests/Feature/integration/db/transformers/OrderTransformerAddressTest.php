<?php

namespace Tests\Feature\integration\db\transformers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderTransformerAddressTest extends AbstractTestOrderTransformer
{
    protected function setUp()
    {
        parent::setUp();
        $this->resetOrderTransformerSingle(false, true);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function if_the_address_parameter_is_set_to_true_then_it_will_include_the_shipping_address_information()
    {
        $this->assertArrayHasKey('address', $this->orderTransformerSingle['order']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function if_the_address_parameter_is_set_to_false_then_it_will_not_include_the_shipping_address_information()
    {
        $this->resetOrderTransformerSingle();
        $this->assertArrayNotHasKey('address', $this->orderTransformerSingle['order']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function the_address_array_must_return_the_street_address()
    {
        $this->assertArrayHasKey('street_address', $this->orderTransformerSingle['order']['address']);
        $this->assertEquals($this->addresses[0]->address, $this->orderTransformerSingle['order']['address']['street_address']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function the_address_array_must_return_the_state()
    {
        $this->assertArrayHasKey('state', $this->orderTransformerSingle['order']['address']);
        $this->assertEquals($this->addresses[0]->state->name, $this->orderTransformerSingle['order']['address']['state']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function the_address_array_must_return_the_city()
    {
        $this->assertArrayHasKey('city', $this->orderTransformerSingle['order']['address']);
        $this->assertEquals($this->addresses[0]->city, $this->orderTransformerSingle['order']['address']['city']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function the_address_array_must_return_the_postal_code()
    {
        $this->assertArrayHasKey('postal_code', $this->orderTransformerSingle['order']['address']);
        $this->assertEquals($this->addresses[0]->postal_code, $this->orderTransformerSingle['order']['address']['postal_code']);
    }

}
