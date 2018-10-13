<?php
/*
|--------------------------------------------------------------------------
| CreateNewStatesSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to create a new state
|    As a an admin
|    I need to add a state to the database
|
| Scenario:
|   Given: I am an admin
|   And : the form data is correct
|   When: I submit a request for a new state
|   Then: A new state will be saved in the database and I will receive a success message
*/
namespace Tests\Feature\acceptance\admin\states;

use Tests\Feature\acceptance\admin\AbstractTestPost;
use Tests\TestCase;

class CreateNewStatesSuccessTest extends AbstractTestPost
{
    protected $postRoute = 'admin/api/states';

    protected $post = ['name' => 'New South Wales', 'abbreviation' => 'nsw'];

    protected function setUp()
    {
        parent::setUp();
        $this->sendRequest();
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
        $this->postResponse->assertJson(['message' => 'You have created a new state!']);
    }

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function it_must_have_the_new_category_in_the_database()
    {
        $this->assertDatabaseHas('states', [
            'name' => 'New South Wales',
            'abbreviation' => 'nsw'
        ]);
    }
}
