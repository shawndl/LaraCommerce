<?php

namespace Tests\Feature\integration\db\transformers;

use App\Address;
use App\Library\Transformer\AddressTransformer;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddressTransformerTest extends TestCase
{
    use DatabaseMigrations, \SetUpAddressTrait;

    /**
     * @var Collection
     */
    protected $addresses;

    /**
     * @var array
     */
    protected $addressTransformed;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpAddress();
        $this->addressTransformed = AddressTransformer::single(Address::first());
        $this->addresses = Address::all();
    }

    /** @test */
    public function it_must_be_able_to_return_an_array_for_a_collection_of_addresses()
    {
        $this->assertCount(3, AddressTransformer::transform($this->addresses));
    }

    /** @test */
    public function it_must_be_able_to_return_an_array_for_single_address()
    {
        $this->assertArrayHasKey('id', $this->addressTransformed);
    }

    /** @test */
    public function it_must_return_the_state()
    {
        $this->assertContains('Colorado', $this->addressTransformed);
        $this->assertArrayHasKey('state', $this->addressTransformed);
    }

    /** @test */
    public function it_must_return_the_city()
    {
        $this->assertContains('Springfield', $this->addressTransformed);
        $this->assertArrayHasKey('city', $this->addressTransformed);
    }

    /** @test */
    public function it_must_return_the_street_address()
    {
        $this->assertContains('123 Fake St.', $this->addressTransformed);
        $this->assertArrayHasKey('street_address', $this->addressTransformed);
    }

    /** @test */
    public function it_must_return_the_postal_code()
    {
        $this->assertContains('27299', $this->addressTransformed);
        $this->assertArrayHasKey('postal_code', $this->addressTransformed);
    }
}
