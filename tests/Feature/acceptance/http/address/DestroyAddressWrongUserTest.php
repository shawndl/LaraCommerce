<?php

namespace Tests\Feature\acceptance\http\address;

use App\Address;
use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DestroyAddressWrongUserTest  extends AbstractHttpAjaxTestClass
{
    use \SetUpAddressTrait;

    protected $addressID;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpAddress();
        $this->addSecondUser();
        $this->addressID = $this->addresses[0]->id;
        $this->postRoute = 'user/address/'. $this->addressID;
        $this->setPostResponseUser([
            '_method' => 'Delete',
        ], false);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function the_address_must_not_be_deleted()
    {
        $address = Address::find($this->addressID);
        $this->assertNotNull($address);
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
    public function the_status_code_must_be_404()
    {
        $this->postResponse->assertStatus(401);
    }
}