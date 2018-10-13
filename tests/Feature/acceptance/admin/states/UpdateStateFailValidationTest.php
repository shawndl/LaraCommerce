<?php
/*
|--------------------------------------------------------------------------
| UpdateStateFailValidationTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent invalid states from being saved in the database
|    As an admin
|    I want to update a state with bad information
|
| Scenario:
|   Given: I am an admin
|   And: I have completed an update form with bad info
|   When: I submit a request
|   Then: The state should not be updated and I should receive an error message
*/
namespace Tests\Feature\acceptance\admin\states;

use Tests\Feature\acceptance\admin\AbstractTestPost;

class UpdateStateFailValidationTest extends AbstractTestPost
{
    use \SetUpAddressTrait;

    protected $postRoute = 'admin/api/states';

    protected $post = ['_method' => 'PATCH', 'name' => '', 'abbreviation' => 'nsw'];

    protected function setUp()
    {
        parent::setUp();
        $this->setUpState();
        $this->postRoute = $this->postRoute . '/' . $this->state->id;
        $this->sendRequest(true, false);
    }


    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function validation_errors_must_return_a_status_of_422()
    {
        $this->sendRequest();
        $this->postResponse->assertStatus(422);
    }

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function the_state_must_have_a_name()
    {
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The name field is required.']);
    }

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function the_state_must_have_only_letters_and_spaces()
    {
        $this->post['name'] = '281 Cows';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The name may only contain letters and spaces.']);
    }

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function the_state_must_have_an_abbreviation()
    {
        $this->post = ['_method' => 'PATCH', 'name' => 'New South Wales', 'abbreviation' => ''];
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The abbreviation field is required.']);
    }

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function the_abbreviation_must_have_only_letters()
    {
        $this->post['abbreviation'] = '281';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The abbreviation may only contain letters.']);
    }
}
