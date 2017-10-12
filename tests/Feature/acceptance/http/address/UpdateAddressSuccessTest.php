<?php
/*
|--------------------------------------------------------------------------
| UpdateAddressSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to update a shipping address
|    As a user
|    I need update a shipping address
|
| Scenario:
|   Given: I have updated the address form
|   And: I am logged in
|   When: I have submitted my request to user/order
|   Then: A new address should be created
*/
namespace Tests\Feature\acceptance\http\address;

use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;

class UpdateAddressSuccessTest extends AbstractHttpAjaxTestClass
{
    use \SetUpAddressTrait;

    protected $post = [];

    protected function setUp()
    {
        parent::setUp();
        $this->setUpAddress();
        $this->postRoute = 'user/address/'. $this->addresses[0]->id;
        $this->setPost();
        $this->setPostResponseUser($this->post);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function a_must_update_the_address()
    {
        $address = $this->user->addresses()->first()->toArray();
        $this->assertEquals($address['address'], $this->post['street_address']);
        $this->assertEquals($address['city'], $this->post['city']);
        $this->assertEquals($address['state_id'], $this->post['state']);
        $this->assertEquals($address['postal_code'], $this->post['postal_code']);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function it_must_return_a_success_message()
    {
        $this->postResponse->assertJsonFragment(['message' =>
            'You have updated your address']);
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
            '_method' => 'PATCH',
            'street_address' => '59 Lake Ln.',
            'state' => $this->state->id,
            'city' => 'Lakewood',
            'postal_code' => '80521'
        ];
    }
}
