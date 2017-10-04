<?php
/*
|--------------------------------------------------------------------------
| CreateNewTaxFailAuthTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent users from creating taxes
|    As a user or a guest
|    I want to create a tax
|
| Scenario:
|   Given: I am a user or a guest
|   When: I submit a request for a new tax
|   Then: I should receive a redirect or an error message
*/
namespace Tests\Feature\acceptance\admin\tax;

use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateNewTaxFailAuthTest extends AbstractHttpAjaxTestClass
{
    protected $postRoute = 'admin/api/taxes';

    /**
     * @group tax
     * @group acceptance
     * @test
     */
    public function guests_can_not_submit_this_form()
    {
        $this->setPostResponse(['name' => 'Food']);
        $this->postResponse->assertStatus(401);
    }

    /**
     * @group tax
     * @group acceptance
     * @test
     */
    public function users_can_not_submit_this_form()
    {
        $this->setPostResponseUser(['name' => 'Food']);
        $this->postResponse->assertStatus(302);
    }
}
