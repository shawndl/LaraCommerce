<?php
/*
|--------------------------------------------------------------------------
| ShowUserOrderWrongUserTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent users from viewing orders that do not belong to them
|    As a user
|    I need I want to view another users order
|
| Scenario:
|   Given: I am a user who is logged in
|   And: I want to view an order that does not belong to me
|   When: visit the 'user/user-account/order/{another-users-order}' page
|   Then: I should be redirected to the home page with an error
*/
namespace Tests\Feature\acceptance\http\viewAccount\route\show;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class ShowUserOrderWrongUserTest extends AbstractHttpTestClass
{
    use \SetUpOrderTrait;
    protected $getRoute = 'user/user-account/order/';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpOrderDatabase();
        $this->getRoute = $this->getRoute . $this->orders[0]->id;
        $this->addSecondUser();
        $this->changeOrdersUser($this->secondUser);
        $this->setGetResponseUser();
    }

    /**
     * @group acceptance
     * @group user_account
     * @test
     */
    public function the_order_must_belong_to_the_user()
    {
        $this->getResponse->assertRedirect('/');
    }

    /**
     * @group acceptance
     * @group user_account
     * @test
     */
    public function the_redirect_must_have_an_error_message()
    {
        $this->getResponse->assertSessionHas('error',
            'The order you selected does not belong to your account');
    }
}

