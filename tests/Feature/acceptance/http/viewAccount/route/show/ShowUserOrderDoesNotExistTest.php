<?php
/*
|--------------------------------------------------------------------------
| ShowUserOrderDoesNotExistTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent a user from probing the system to determine what orders exist
|    As a user
|    I need I entered an order that does not exist
|
| Scenario:
|   Given: I am a user who is logged in
|   And: I I enter an order that does not exist
|   When: visit the 'user/user-account/order/{test-if-order-exists}' page
|   Then: I should be redirected to the home page with an error
*/
namespace Tests\Feature\acceptance\http\viewAccount\route\show;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class ShowUserOrderDoesNotExistTest extends AbstractHttpTestClass
{
    protected $getRoute = 'user/user-account/order/cake';

    public function setUp()
    {
        parent::setUp();
        $this->setGetResponseUser();
    }

    /**
     *  @test
     *  @group useraccount
     *  @group acceptance
     */
    public function the_user_must_be_redirected_if_they_choose_an_order_that_does_not_exist()
    {
        $this->getResponse->assertRedirect('/');
    }

    /**
     *  @test
     *  @group useraccount
     *  @group acceptance
     */
    public function the_redirect_must_have_an_error_message()
    {
        $this->getResponse->assertSessionHas('error',
            'The order you selected does not belong to your account');
    }
}
