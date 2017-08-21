<?php
/*
|--------------------------------------------------------------------------
| ShowUserOrderNotLoggedInTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent users from viewing orders that do not belong to them
|    As a user
|    I need I want to view an order
|    And I am not logged in
|
| Scenario:
|   Given: I am a user and I visited the user-account/order page
|   When: visit the 'user/user-account/order/{another-users-order}' page
|   Then: I should be redirected to the login page
*/

namespace Tests\Feature\acceptance\http\viewAccount\route\show;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class ShowUserOrderNotLoggedInTest extends AbstractHttpTestClass
{
    protected $getRoute = 'user/user-account/order/51';

    /**
     *  @test
     *  @group useraccount
     *  @group acceptance
     */
    public function the_user_must_be_logged_in()
    {
        $this->getResponse->assertRedirect('login');
    }
}
