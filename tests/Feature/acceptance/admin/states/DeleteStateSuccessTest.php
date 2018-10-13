<?php
/*
|--------------------------------------------------------------------------
| DeleteStateSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to delete
|    As a an admin
|    I need to remove a state to the database
|
| Scenario:
|   Given: I am an admin
|   And : the form data is correct
|   When: I submit a request to delete
|   Then: The state will be removed from the database and I will receive a success message
*/
namespace Tests\Feature\acceptance\admin\states;

use Tests\Feature\acceptance\admin\AbstractTestPost;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeleteStateSuccessTest extends AbstractTestPost
{
    use \SetUpAddressTrait;

    protected $postRoute = 'admin/api/states';

    protected $post = ['_method' => 'DELETE'];

    protected function setUp()
    {
        parent::setUp();
        $this->setUpState();
        $this->postRoute = $this->postRoute . '/'  . $this->state->id;
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
        $this->postResponse
            ->assertStatus(200);
    }

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function it_must_return_a_success_message()
    {
        $this->postResponse->assertJson([
            'message' => 'You deleted a state!'
        ]);
    }

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function it_must_delete_the_state_from_the_database()
    {
        $this->assertDatabaseMissing('states', [
            'name' => $this->state->name
        ]);
    }
}
