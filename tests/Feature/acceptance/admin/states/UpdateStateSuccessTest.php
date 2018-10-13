<?php
/*
|--------------------------------------------------------------------------
| UpdateStateSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to update states in the database
|    As a an admin
|    I need to update a state to the database
|
| Scenario:
|   Given: I am an admin
|   And : the form data is correct
|   When: I submit a request
|   Then: The state will be updated in the database and I will receive a success message
*/
namespace Tests\Feature\acceptance\admin\states;

use Tests\Feature\acceptance\admin\AbstractTestPost;

class UpdateStateSuccessTest extends AbstractTestPost
{
    use \SetUpAddressTrait;

    protected $postRoute = 'admin/api/states';

    protected $post = ['_method' => 'PATCH', 'name' => 'New South Wales', 'abbreviation' => 'nsw'];

    protected function setUp()
    {
        parent::setUp();
        $this->setUpState();
        $this->postRoute = $this->postRoute . '/' . $this->state->id;
        $this->sendRequest(true, true);
    }

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function it_must_return_a_status_of_200()
    {
        $this->postResponse->assertStatus(200);
    }

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function it_must_return_a_success_message()
    {
        $this->postResponse->assertJson(['message' => 'You have updated a state!']);
    }

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function it_must_have_the_updated_state_in_the_database()
    {
        $this->assertDatabaseHas('states', [
            'name' => 'New South Wales',
            'abbreviation' => 'nsw'
        ]);

        $this->assertDatabaseMissing('states', [
            'name' => $this->state->name,
            'abbreviation' => $this->state->abbreviation
        ]);
    }
}
