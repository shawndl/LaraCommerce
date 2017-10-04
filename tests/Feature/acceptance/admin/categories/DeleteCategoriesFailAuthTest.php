<?php
/*
|--------------------------------------------------------------------------
| DeleteCategoriesFailAuthTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent guests and users from deleting categories
|    As a guest
|    I want to delete a category
|
| Scenario:
|   Given: I am a guest
|   When: I submit a delete request
|   Then: I should receive a 422 error and the category should not be deleted
*/
namespace Tests\Feature\acceptance\admin\categories;

use App\Category;
use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeleteCategoriesFailAuthTest extends AbstractHttpAjaxTestClass
{
    use \SetUpCategoryTrait;

    protected $postRoute = 'admin/api/categories';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpCategory();
        $this->postRoute = $this->postRoute . '/'  . $this->category->id;
    }

    /**
     * @group category
     * @group acceptance
     * @test
     */
    public function guests_can_not_submit_this_form()
    {
        $this->setPostResponse(['name' => 'Food', '_method' => 'DELETE']);
        $this->postResponse->assertStatus(401);
    }
}
