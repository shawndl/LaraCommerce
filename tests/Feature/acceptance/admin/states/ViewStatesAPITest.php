<?php
/*
|--------------------------------------------------------------------------
| ViewStatesAPITest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to inform admins what state are in the database
|    As a an admin
|    I need to manage the states available in the database
|
| Scenario:
|   Given: I am an admin
|   When: I submit a request
|   Then: a json object with all the states should be returned
*/
namespace Tests\Feature\acceptance\admin\states;

use App\State;
use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;


class ViewStatesAPITest extends AbstractHttpAjaxTestClass
{
    protected $getRoute = 'admin/api/states';

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function only_admins_can_receive_results_from_the_states_api_call()
    {
        $this->get($this->getRoute)
            ->assertRedirect('login');
    }

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function it_must_return_all_the_states()
    {
        $states = factory(State::class, 5)->create();
        $this->setGetResponseAdmin();
        foreach ($states as $state)
        {
            $this->getResponse->assertJsonFragment(['id' => $state->id, 'name' => $state->name]);
        }


    }
}
