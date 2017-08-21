<?php
/*
|--------------------------------------------------------------------------
| UserViewsAccountNotLoggedInTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to assist users to view the correct account information
|    As a user who is not logged in
|    I need to view my account details
|
| Scenario:
|   Given: I am a user who is not signed in
|   When: I visit the UserAccountController@index route
|   Then: I must be redirected to the login in screen
*/

namespace Tests\Feature\acceptance\http\viewAccount\route\index;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserViewsAccountNotLoggedInTest extends AbstractHttpTestClass
{
    protected $getRoute = 'user/user-account';

    /**
     *  @test
     *  @group useraccount
     *  @group acceptance
     */
    public function the_user_must_be_redirected_to_the_login_screen()
    {
        $this->getResponse->assertRedirect('login');
    }
}
