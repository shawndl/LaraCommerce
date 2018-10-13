<?php
/*
|--------------------------------------------------------------------------
| ViewStatesPageTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to manage the states in the database
|    As a an admin
|    I need to manage the states available in the database
|
| Scenario:
|   Given: I am an admin
|   When: I visit this page
|   Then: I should see a page with information about the states available
*/
namespace Tests\Feature\acceptance\admin\states;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class ViewStatesPageTest extends AbstractHttpTestClass
{
    protected $getRoute = 'admin/states';

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function the_states_admin_page_must_return_a_status_of_200()
    {
        $this->setGetResponseAdmin();
        $this->getResponse->assertStatus(200);
    }

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function only_an_admin_can_view_the_states_admin_page()
    {
        $this->get($this->getRoute)
            ->assertRedirect('/login');
    }

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function the_states_admin_page_must_use_the_admin_index_page()
    {
        $this->setGetResponseAdmin();
        $this->getResponse->assertViewIs('admin.index');
    }

    /**
     * @group admin
     * @group states
     * @group acceptance
     * @test
     */
    public function it_must_have_the_states_table_attached_to_the_view()
    {
        $this->setGetResponseAdmin();
        $this->getResponse
            ->assertViewHas(['table' => 'admin._includes._tables._states']);
    }
}
