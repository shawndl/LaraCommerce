<?php
/*
|--------------------------------------------------------------------------
| OrderPageNotLoggedInTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent access to the order page without authentication
|    As a user
|    I need to view the order page
|
| Scenario:
|   Given: I have sent a get request to 'order/{stage}
|   And: I am not logged in
|   When: I send the request
|   Then: I should be redirected to the login page
*/
namespace Tests\Feature\acceptance\http\order\route;

use Illuminate\Foundation\Testing\TestResponse;
use Tests\Feature\acceptance\http\AbstractHttpTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderPageNotLoggedInTest extends AbstractHttpTestClass
{
    protected $getRoute = 'order/edit-order';

    protected function setUp()
    {
        parent::setUp();
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function the_user_must_be_redirected_to_the_login_screen()
    {
        $this->getResponse->assertRedirect('login');
    }

}
