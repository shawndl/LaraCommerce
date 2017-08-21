<?php
/*
|--------------------------------------------------------------------------
| OrderPageInvalidStageTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order a user from enter a url route that does not exist
|    As a user
|    I need to be redirected to the edit-order page
|
| Scenario:
|   Given: I have sent a get request to 'order/an-invalid-parameter
|   And: I am logged in
|   When: I send the request
|   Then: I should be redirected to the edit order page
*/
namespace Tests\Feature\acceptance\http\order\route;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderPageInvalidStageTest extends AbstractHttpTestClass
{
    protected $getRoute = 'order/some-other-value';

    protected function setUp()
    {
        parent::setUp();
        $this->setGetResponseUser();
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function if_the_user_enters_an_invalid_stage_then_they_should_be_redirected_to_the_edit_order_page()
    {
        $this->getResponse->assertRedirect('order/edit-order');
    }
}
