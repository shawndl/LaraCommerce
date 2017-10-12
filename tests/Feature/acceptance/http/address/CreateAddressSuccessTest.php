<?php
/*
|--------------------------------------------------------------------------
| CreateAddressSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to obtain a shipping address
|    As a user
|    I need enter a new shipping address
|
| Scenario:
|   Given: have fill completed a new address form
|   When: I have submitted my request to user/order
|   Then: A new address should be created
*/
namespace Tests\Feature\acceptance\http\address;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class CreateAddressSuccessTest extends AbstractHttpTestClass
{
    use \SetUpAddressTrait;
    protected $postRoute = 'user/address';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpState();
        $this->setPostResponseUser([
            'street_address' => '123 Fake St.',
            'state' => $this->state->id,
            'city' => 'South Park',
            'postal_code' => '80521'
        ]);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function a_must_be_new_address_must_be_created()
    {
        $this->assertEquals(1, $this->countAddresses());
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function it_must_belong_to_the_user_logged_in()
    {
        $address = $this->getAllAddresses()->first();
        $this->assertEquals($address->user_id, $this->user->id);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function it_must_return_a_success_message()
    {
        $this->postResponse->assertJsonFragment(['message' =>
            'You have added an address!']);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function it_must_return_a_list_of_user_addresses()
    {
        $this->postResponse->assertJsonStructure([
            'message',
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

}
