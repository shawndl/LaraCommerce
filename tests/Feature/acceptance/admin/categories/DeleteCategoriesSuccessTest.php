<?php
/*
|--------------------------------------------------------------------------
| DeleteCategoriesSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to allow administrators to delete categories
|    As a admin
|    I need to delete a category
|
| Scenario:
|   Given: I am an admin
|   When: I submit a delete request
|   Then: I must receive a success message and the category must be deleted
*/
namespace Tests\Feature\acceptance\admin\categories;

use Tests\Feature\acceptance\admin\AbstractTestPost;
class DeleteCategoriesSuccessTest extends AbstractTestPost
{
    use \SetUpCategoryTrait;

    protected $postRoute = 'admin/api/categories';

    protected $post = ['_method' => 'DELETE'];

    protected function setUp()
    {
        parent::setUp();
        $this->setUpCategory();
        $this->postRoute = $this->postRoute . '/'  . $this->category->id;
        $this->sendRequest();
    }

    /**
     * @group category
     * @group acceptance
     * @test
     */
    public function it_must_return_a_status_of_200()
    {
        $this->postResponse
            ->assertStatus(200);
    }

    /**
     * @group category
     * @group acceptance
     * @test
     */
    public function it_must_return_a_success_message()
    {
        $this->postResponse->assertJson([
            'message' => 'You deleted a category!'
        ]);
    }

    /**
     * @group category
     * @group acceptance
     * @test
     */
    public function it_must_delete_the_category_from_the_database()
    {
        $this->assertDatabaseMissing('categories', [
            'name' => $this->category->name
        ]);
    }
}
