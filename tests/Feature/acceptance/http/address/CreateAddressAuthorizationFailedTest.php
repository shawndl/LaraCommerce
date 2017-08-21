<?php
/*
|--------------------------------------------------------------------------
| CreateAddressAuthorizationFailedTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent unauthorized users from created addresses
|    As a user
|    I need create an address
|
| Scenario:
|   Given: I am a user who is not logged in
|   When: submit my address form
|   Then: I should receive an error message
*/
namespace Tests\Feature\acceptance\http\address;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class CreateAddressAuthorizationFailedTest extends AbstractHttpTestClass
{
    use \SetUpAddressTrait;
    protected $postRoute = 'user/address';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpState();
        $this->setPostResponse([
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
        $this->assertEquals(0, $this->countAddresses());
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
    public function the_status_code_must_be_404()
    {
        $this->postResponse->assertStatus(401);
    }
}
