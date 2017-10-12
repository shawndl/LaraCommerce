<?php
/*
|--------------------------------------------------------------------------
| CreateCategoriesFailAuthTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent guests or users from creating categories
|    As a guest
|    I want to create a new category
|
| Scenario:
|   Given: I am not an admin
|   When: post a request for a new category
|   Then: I should receive a 401
*/
namespace Tests\Feature\acceptance\admin\categories;

use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateCategoriesFailAuthTest extends AbstractHttpAjaxTestClass
{
    protected $postRoute = 'admin/api/categories';

    /**
     * @group admin
     * @group category
     * @group acceptance
     * @test
     */
    public function guests_can_not_submit_this_form()
    {
        $this->setPostResponse(['name' => 'Food']);
        $this->postResponse->assertStatus(401);
    }

    /**
     * @group admin
     * @group category
     * @group acceptance
     * @test
     */
    public function users_can_not_submit_this_form()
    {
        $this->setPostResponseUser(['name' => 'Food']);
        $this->postResponse->assertStatus(302);
    }
}
