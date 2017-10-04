<?php
/*
|--------------------------------------------------------------------------
| CreateSaleFailAuthTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent unauthorized users from adding sales
|    As a ....
|    I need ....
|
| Scenario:
|   Given:
|   When:
|   Then:
*/
namespace Tests\Feature\acceptance\admin\sale;

use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateSaleFailAuthTest extends AbstractTestSale
{
    /**
     * @group sales
     * @group admin
     * @group acceptance
     * @test
     */
    public function guests_can_not_submit_this_form()
    {
        $this->setPostResponse([]);
        $this->postResponse->assertStatus(401);
    }

    /**
     * @group sales
     * @group admin
     * @group acceptance
     * @test
     */
    public function users_that_are_not_admin_can_not_submit_this_form()
    {
        $this->setPostResponseUser([]);
        $this->postResponse->assertStatus(302);
    }
}
