<?php
/*
|--------------------------------------------------------------------------
| LoginUserSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to log in users
|    As a user
|    I need login
|
| Scenario:
|   Given: I have submitted by login form
|   And: the information is correct
|   When: I submit
|   Then: I should be redirected to the home page
*/
namespace Tests\Feature\acceptance\http\login;


use Illuminate\Support\Facades\Auth;
use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class LoginUserSuccessTest extends AbstractHttpTestClass
{
    protected $postRoute = 'login';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpUser();
        $this->setPostResponse([
            'email' => 'email@company.com',
            'password' => 'secret'
        ]);
    }

    /**
     *  @test
     *  @group login
     *  @group acceptance
     */
    public function it_must_log_in_the_user()
    {
        $this->assertTrue(Auth::check());
    }

    /**
     *  @test
     *  @group login
     *  @group acceptance
     */
    public function it_must_redirect_to_the_home_page()
    {
        $this->postResponse->assertRedirect('/');
    }
}
