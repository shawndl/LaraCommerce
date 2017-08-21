<?php
/*
|--------------------------------------------------------------------------
| UpdateAddressAuthorizationFailedTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature: 
|    In order to prevent unauthorized users from updating addresses
|    As a user
|    I need updating an address
|
| Scenario:
|   Given: I am a user who is not logged in
|   When: submit my address form
|   Then: I should receive an error message
*/
namespace Tests\Feature\acceptance\http\address;

use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;

class UpdateAddressAuthorizationFailedTest extends AbstractHttpAjaxTestClass
{
    use \SetUpAddressTrait;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpAddress();
        $this->addSecondUser();
        $this->postRoute = 'user/address/'. $this->addresses[0]->id;
        $this->setPostResponse([
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
