<?php

namespace Tests\Feature\integration\db\models;

use App\Address;
use App\State;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddressModelTest extends TestCase
{
    use DatabaseMigrations, \SetUpAddressTrait;

    public function setUp()
    {
        parent::setUp();
        $this->setUpAddress();
    }

    /**
     * @test
     * @group integration
     * @group models
     */
    public function it_must_be_able_to_return_the_full_address_with_the_state()
    {
        $this->assertEquals('123 Fake St.', $this->addresses[0]->address);
        $this->assertEquals('Springfield', $this->addresses[0]->city);
        $this->assertEquals('27299', $this->addresses[0]->postal_code);
        $this->assertEquals('Colorado', $this->addresses[0]->state->name);
    }

    /**
     * @test
     * @group integration
     * @group models
     */
    public function it_must_be_able_to_determine_if_a_result_was_returned_or_not()
    {
        $address = new Address();
        $this->assertFalse($address->hasResult());
        $this->assertTrue($this->addresses[0]->hasResult());
    }
}
