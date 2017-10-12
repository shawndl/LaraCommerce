<?php
/*
|--------------------------------------------------------------------------
| ViewCategoriesAPITest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to administer categories
|    As a Admin
|    I need send an ajax request for categories
|
| Scenario:
|   Given: I am an admin
|   When: send an ajax request to 'admin/categories/api'
|   Then: I must receive a json object with all the categories
*/
namespace Tests\Feature\acceptance\admin\categories;


use App\Category;
use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;

class ViewCategoriesAPITest extends AbstractHttpAjaxTestClass
{
    protected $getRoute = 'admin/api/categories';

    /**
     * @group category
     * @group acceptance
     * @group admin
     * @test
     */
    public function only_admins_can_receive_results_this_page()
    {
        $this->get($this->getRoute)
            ->assertRedirect('login');
    }

    /**
     * @group category
     * @group acceptance
     * @group admin
     * @test
     */
    public function it_must_return_all_the_categories()
    {
        $categories = factory(Category::class, 5)->create();
        $this->setGetResponseAdmin();
        foreach ($categories as $category)
        {
            $this->getResponse->assertJsonFragment(['id' => $category->id, 'name' => $category->name]);
        }


    }
}
