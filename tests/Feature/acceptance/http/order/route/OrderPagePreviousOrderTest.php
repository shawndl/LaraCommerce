<?php
/*
|--------------------------------------------------------------------------
| OrderPagePreviousOrderTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to retrieve a previous order
|    As a user
|    I need to access my previous order if I leave or refresh the order page
|
| Scenario:
|   Given: I have sent a get request to 'order/{stage}
|   And: I have a previous order and am logged in
|   When: I send the request
|   Then: I should view the ecommerce.order view with my order
*/
namespace Tests\Feature\acceptance\http\order\route;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderPagePreviousOrderTest extends AbstractHttpTestClass
{
    protected $getRoute = 'order/edit-order';

    protected $fakeOrder = ['user_order' => [
        'order_id'  => 1,
        'address'   => [],
        'user'      => []
    ]];

    protected function setUp()
    {
        parent::setUp();
        $this->setGetResponseUserSession($this->fakeOrder);
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function the_user_must_be_able_to_view_the_order_page()
    {
        $this->getResponse->assertViewIs('ecommerce.order');
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function the_view_must_have_the_users_addresses()
    {
        $this->getResponse->assertViewHas('addresses');
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function the_view_must_have_the_stage()
    {
        $this->getResponse->assertViewHas('stage', 'edit-order');
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function the_view_must_have_an_order_equal_to_the_fake_order()
    {
        $this->getResponse->assertViewHas('order',
            json_encode($this->fakeOrder['user_order']));
    }
}
