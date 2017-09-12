<?php
/*
|--------------------------------------------------------------------------
| ShowUserOrderSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to provide the customer information about previous orders
|    As a user
|    I need I want to view a previous order
|
| Scenario:
|   Given: I am a user who is logged in
|   And: I want to view one of my orders
|   When: visit the 'user/user-account/order/{id}' page
|   Then: I should have access to the userAccount view
*/
namespace Tests\Feature\acceptance\http\viewAccount\route\show;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class ShowUserOrderSuccessTest extends AbstractHttpTestClass
{
    use \SetUpOrderTrait;
    protected $getRoute = 'user/user-account/order/';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpOrderDatabase(true);
        $this->getRoute = $this->getRoute . $this->orders[0]->id;
        $this->setGetResponseUser();
    }


    /**
     * @group acceptance
     * @group user_account
     * @test
     */
    public function it_must_return_the_user_account_view()
    {
        $this->getResponse->assertViewIs('ecommerce.accountOrder');
    }

    /**
     * @group acceptance
     * @group user_account
     * @test
     */
    public function the_view_must_have_the_order_id()
    {
        $this->getResponse->assertViewHas('order_id', $this->orders[0]->id);
    }
}
