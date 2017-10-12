<?php

namespace Tests\Feature\acceptance\http\address;

use App\Address;
use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;

class DestroyAddressSuccessTest extends AbstractHttpAjaxTestClass
{
    use \SetUpAddressTrait;

    protected $post = [];

    /**
     * @var int
     */
    protected $addressID;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpAddress();
        $this->addressID = $this->addresses[0]->id;
        $this->postRoute = 'user/address/'. $this->addressID;
        $this->setPost();
        $this->setPostResponseUser($this->post);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function a_address_must_be_deleted()
    {
        $address = Address::find($this->addressID);
        $this->assertNull($address);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function it_must_return_a_success_message()
    {
        $this->postResponse->assertJsonFragment(['message' =>
            'You deleted an address!']);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function it_must_return_a_list_of_user_addresses()
    {
        $this->postResponse->assertJsonStructure([
            'message'
        ]);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function the_status_code_must_be_200()
    {
        $this->postResponse->assertStatus(200);
    }

    /**
     * sets the post array
     *
     * @return void
     */
    private function setPost()
    {
        $this->post = [
            '_method' => 'DELETE'
        ];
    }
}
