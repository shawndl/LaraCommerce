<?php
/*
|--------------------------------------------------------------------------
| CreateNewStateFailAuthTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent non-admin from creating states
|    As a user
|    I want to create a new state
|
| Scenario:
|   Given: I am not an admin
|   When: I submit a request for a new state
|   Then: A new state should not be created and I should receive an error message
*/
namespace Tests\Feature\acceptance\admin\states;

use Tests\Feature\acceptance\admin\AbstractTestPost;

class CreateNewStateFailAuthTest extends AbstractTestPost
{
    protected $postRoute = 'admin/api/states';

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function guests_can_not_submit_a_new_state_form()
    {
        $this->setPostResponse(['name' => 'Colorado']);
        $this->postResponse->assertStatus(401);
    }

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function users_can_not_submit_a_new_state_form()
    {
        $this->setPostResponseUser(['name' => 'Colorado']);
        $this->postResponse->assertStatus(302);
    }
}
