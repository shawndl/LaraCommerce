<?php
/*
|--------------------------------------------------------------------------
| ViewCategoriesPageTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to administer categories
|    As a admin
|    I need view the products page
|
| Scenario:
|   Given: I am an admin and I want to view the admin page
|   When: I visit the admin/categories page
|   Then: I must see the admin page
*/
namespace Tests\Feature\acceptance\admin\categories;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewCategoriesPageTest extends AbstractHttpTestClass
{
    protected $getRoute = 'admin/categories';

    /**
     * @group category
     * @group acceptance
     * @test
     */
    public function only_an_admin_can_view_this_page()
    {
        $this->get($this->getRoute)
            ->assertRedirect('/login');
    }

    /**
     * @group category
     * @group acceptance
     * @test
     */
    public function it_must_use_the_admin_index_page()
    {
        $this->setGetResponseAdmin();
        $this->getResponse->assertViewIs('admin.index');
    }

    /**
     * @group category
     * @group acceptance
     * @test
     */
    public function it_must_have_the_categories_table_attached_to_the_view()
    {
        $this->setGetResponseAdmin();
        $this->getResponse
            ->assertViewHas(['table' => 'admin._includes._tables._categories']);
    }
}
