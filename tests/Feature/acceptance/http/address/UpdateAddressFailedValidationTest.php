<?php

namespace Tests\Feature\acceptance\http\address;

use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;

class UpdateAddressFailedValidationTest extends AbstractHttpAjaxTestClass
{
    use \SetUpAddressTrait;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpAddress();
        $this->postRoute = 'user/address/'. $this->addresses[0]->id;
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function the_street_address_is_required_or_it_will_return_an_error_message()
    {
        $this->setPostResponseUser([
            '_method' => 'PATCH',
            'street_address' => '',
            'state' => $this->state->id,
            'city' => 'South Park',
            'postal_code' => '80521'
        ]);
        $this->postResponse->assertJson(['street_address' => ['The street address field is required.']]);
        $this->postResponse->assertStatus(422);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function the_street_address_may_only_contain_letters_and_numbers_or_it_will_return_an_error_message()
    {
        $this->setPostResponseUser([
            '_method' => 'PATCH',
            'street_address' => '?%#@^',
            'state' => $this->state->id,
            'city' => 'South Park',
            'postal_code' => '80521'
        ]);
        $this->postResponse->assertJson(['street_address' => ['The street address format is invalid.']]);
        $this->postResponse->assertStatus(422);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function the_state_is_required_or_it_will_return_an_error_message()
    {
        $this->setPostResponseUser([
            '_method' => 'PATCH',
            'street_address' => '123 Fake St.',
            'state' => '',
            'city' => 'South Park',
            'postal_code' => '80521'
        ]);
        $this->postResponse->assertJson(['state' => ['The state field is required.']]);
        $this->postResponse->assertStatus(422);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function the_state_must_be_a_number_or_it_will_return_an_error_message()
    {
        $this->setPostResponseUser([
            '_method' => 'PATCH',
            'street_address' => '123 Fake St.',
            'state' => 'Colorado',
            'city' => 'South Park',
            'postal_code' => '80521'
        ]);
        $this->postResponse->assertJson(['state' => ['The state must be a number.']]);
        $this->postResponse->assertStatus(422);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function the_city_is_required_or_it_will_return_an_error_message()
    {
        $this->setPostResponseUser([
            '_method' => 'PATCH',
            'street_address' => '123 Fake St.',
            'state' => $this->state->id,
            'city' => '',
            'postal_code' => '80521'
        ]);
        $this->postResponse->assertJson(['city' => ['The city field is required.']]);
        $this->postResponse->assertStatus(422);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function the_city_must_be_only_letters_or_it_will_return_an_error_message()
    {
        $this->setPostResponseUser([
            '_method' => 'PATCH',
            'street_address' => '123 Fake St.',
            'state' => $this->state->id,
            'city' => 'South 9291',
            'postal_code' => '80521'
        ]);
        $this->postResponse->assertJson(['city' => ['The city may only contain letters and spaces.']]);
        $this->postResponse->assertStatus(422);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function the_postal_code_is_required_or_it_will_return_an_error_message()
    {
        $this->setPostResponseUser([
            '_method' => 'PATCH',
            'street_address' => '123 Fake St.',
            'state' => $this->state->id,
            'city' => 'South Park',
            'postal_code' => ''
        ]);
        $this->postResponse->assertJson(['postal_code' => ['The postal code field is required.']]);
        $this->postResponse->assertStatus(422);
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function the_postal_code_must_be_a_number_or_it_will_return_an_error_message()
    {
        $this->setPostResponseUser([
            '_method' => 'PATCH',
            'street_address' => '123 Fake St.',
            'state' => $this->state->id,
            'city' => 'South Park',
            'postal_code' => 'postal code'
        ]);
        $this->postResponse->assertJson(['postal_code' => ['The postal code format is invalid.']]);
        $this->postResponse->assertStatus(422);
    }
}
