<?php
/*
|--------------------------------------------------------------------------
| ViewTaxPageTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to add update, and delete taxes
|    As a admin
|    I need visit the tax page
|
| Scenario:
|   Given: I an admin
|   When: I visit the tax page
|   Then:  A web-page must be available
*/
namespace Tests\Feature\acceptance\admin\tax;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class ViewTaxPageTest extends AbstractHttpTestClass
{
    protected $getRoute = 'admin/taxes';

    /**
     * @group tax
     * @group acceptance
     * @group admin
     * @test
     */
    public function only_an_admin_can_view_this_page()
    {
        $this->get($this->getRoute)
            ->assertRedirect('/login');
    }

    /**
     * @group tax
     * @group acceptance
     * @group admin
     * @test
     */
    public function it_must_use_the_admin_index_page()
    {
        $this->setGetResponseAdmin();
        $this->getResponse->assertViewIs('admin.index');
    }

    /**
     * @group tax
     * @group acceptance
     * @group admin
     * @test
     */
    public function it_must_have_the_categories_table_attached_to_the_view()
    {
        $this->setGetResponseAdmin();
        $this->getResponse
            ->assertViewHas(['table' => 'admin._includes._tables._taxes']);
    }
}
