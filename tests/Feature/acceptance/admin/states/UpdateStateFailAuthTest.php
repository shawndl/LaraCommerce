<?php
/*
|--------------------------------------------------------------------------
| UpdateStateFailAuthTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent non-admin from updating states
|    As a user
|    I want to update a state
|
| Scenario:
|   Given: I am not an admin
|   When: I submit a request to update a state
|   Then: The state should not be updated and I should receive an error message
*/
namespace Tests\Feature\acceptance\admin\states;

use Tests\Feature\acceptance\admin\AbstractTestPost;

class UpdateStateFailAuthTest extends AbstractTestPost
{
    use \SetUpAddressTrait;

    protected $postRoute = 'admin/api/states';

    protected $post = ['_method' => 'PATCH', 'name' => 'New South Wales'];

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
    public function guests_can_not_submit_this_form()
    {
        $this->postResponse->assertStatus(302);
    }

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function it_must_not_update_the_database()
    {
        $this->assertDatabaseHas('states', [
            'name' => $this->state->name
        ]);

        $this->assertDatabaseMissing('states', [
            'name' => 'New South Wales'
        ]);
    }
}
