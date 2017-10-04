<?php
/*
|--------------------------------------------------------------------------
| CreateCategoriesSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to administer categories
|    As a admin
|    I need create a new category
|
| Scenario:
|   Given: I am an admin
|   When: post a new category to 'admin/categories/api'
|   Then: A new category must be saved in the database
*/
namespace Tests\Feature\acceptance\admin\categories;

use Tests\Feature\acceptance\admin\AbstractTestPost;


class CreateCategoriesSuccessTest extends AbstractTestPost
{
    protected $postRoute = 'admin/api/categories';

    protected $post = ['name' => 'food'];

    protected function setUp()
    {
        parent::setUp();
        $this->sendRequest();
    }

    /**
     * @group category
     * @group acceptance
     * @test
     */
    public function it_must_return_a_status_of_200()
    {
        $this->postResponse->assertStatus(200);
    }

    /**
     * @group category
     * @group acceptance
     * @test
     */
    public function it_must_return_a_success_message()
    {
        $this->postResponse->assertJson(['message' => 'You have created a new category!']);
    }

    /**
     * @group category
     * @group acceptance
     * @test
     */
    public function it_must_have_the_new_category_in_the_database()
    {
        $this->assertDatabaseHas('categories', [
            'name' => 'Food'
        ]);
    }
}
