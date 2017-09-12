<?php

namespace Tests\Feature\acceptance\http\address;

use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateAddressWrongUserTest  extends AbstractHttpAjaxTestClass
{
    use \SetUpAddressTrait;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpAddress();
        $this->addSecondUser();
        $this->postRoute = 'user/address/'. $this->addresses[0]->id;
        $this->setPostResponseUser([
            '_method' => 'PATCH',
            'street_address' => '59 Lake Ln.',
            'state' => $this->state->id,
            'city' => 'Lakewood',
            'postal_code' => '80521'
        ], false);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function the_address_must_not_be_updated()
    {
        $address = $this->user->addresses()->first()->toArray();
        $this->assertEquals('123 Fake St.', $address['address']);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function it_must_return_an_error_message()
    {
        $this->postResponse->assertJsonFragment(['error' =>
            'Error: You are not authorized to perform this action']);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function the_status_code_must_be_403()
    {
        $this->postResponse->assertStatus(403);
    }
}
