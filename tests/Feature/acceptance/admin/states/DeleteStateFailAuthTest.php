<?php
/*
|--------------------------------------------------------------------------
| DeleteStateFailAuthTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent non-admin from deleting states
|    As a user
|    I want to delete a state
|
| Scenario:
|   Given: I am not an admin
|   When: I submit a request to delete a state
|   Then: The state should not be deleted and I should receive an error message
*/
namespace Tests\Feature\acceptance\admin\states;

use Tests\Feature\acceptance\admin\AbstractTestPost;


class DeleteStateFailAuthTest extends AbstractTestPost
{
    use \SetUpAddressTrait;

    protected $postRoute = 'admin/api/states';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpState();
        $this->postRoute = $this->postRoute . '/'  . $this->state->id;
    }

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function guests_can_not_submit_a_delete_state_form()
    {
        $this->setPostResponse(['_method' => 'delete']);
        $this->postResponse->assertStatus(401);
    }

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function users_can_not_submit_a_delete_state_form()
    {
        $this->setPostResponseUser(['_method' => 'delete']);
        $this->postResponse->assertStatus(302);
    }
}