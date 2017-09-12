<?php
/*
|--------------------------------------------------------------------------
| UserViewsAccountSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to give users details about their account
|    As a user
|    I need to view my account details
|
| Scenario:
|   Given: I am a user who is signed in
|   When: I visit the UserAccountController@index route
|   Then: I should see my account information 
*/

namespace Tests\Feature\acceptance\http\viewAccount\route\index;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class UserViewsAccountSuccessTest extends AbstractHttpTestClass
{
    protected $getRoute = 'user/user-account';

    protected function setUp()
    {
        parent::setUp();
        $this->setGetResponseUser();
    }

    /**
     * @group acceptance
     * @group user_account
     * @test
     */
    public function it_must_return_the_eccomerce_account_view()
    {
        $this->getResponse->assertViewIs('ecommerce.account');
    }

    /**
     * @group acceptance
     * @group user_account
     * @test
     */
    public function the_must_have_the_users_order_information()
    {
        $this->getResponse->assertViewHas('user');
    }
}
