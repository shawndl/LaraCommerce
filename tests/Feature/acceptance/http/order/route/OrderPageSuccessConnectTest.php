<?php

/*
|--------------------------------------------------------------------------
| OrderPageSuccessConnectTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to complete my order
|    As a user
|    I need to view the order page
|
| Scenario:
|   Given: I have sent a get request to 'order/{stage}
|   And: I am logged in
|   When: I send the request
|   Then: I should view the ecommerce.order view
*/
namespace Tests\Feature\acceptance\http\order\route;


use Illuminate\Foundation\Testing\TestResponse;
use Tests\Feature\acceptance\http\AbstractHttpTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderPageSuccessConnectTest extends AbstractHttpTestClass
{
    protected $getRoute = 'order/edit-order';

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
    public function the_user_must_be_able_to_view_the_order_page()
    {
        $this->getResponse->assertViewIs('ecommerce.order');
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
    public function the_view_must_have_an_order_equal_to_null()
    {
        $this->getResponse->assertViewHas('order', null);
    }
}
