<?php

namespace Tests\Feature\acceptance\http\address;

use App\Address;
use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;

class DestroyAddressAuthorizationFailedTest extends AbstractHttpAjaxTestClass
{
    use \SetUpAddressTrait;

    /**
     * @var integer
     */
    protected $addressID;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpAddress();
        $this->addSecondUser();
        $this->addressID = $this->addresses[0]->id;
        $this->postRoute = 'user/address/'. $this->addressID;
        $this->setPostResponse([
            '_method' => 'DELETE',
        ], false);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function the_address_must_not_be_updated()
    {
        $address = Address::find($this->addressID);
        $this->assertTrue($address->hasResult());
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function it_must_return_an_error_message()
    {
        $this->postResponse->assertJsonFragment(['error' =>
            'You are not authorized to perform this request!']);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function the_status_code_must_be_401()
    {
        $this->postResponse->assertStatus(401);
    }
}
