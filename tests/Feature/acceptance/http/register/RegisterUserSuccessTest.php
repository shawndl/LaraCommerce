<?php
/*
|--------------------------------------------------------------------------
| RegisterUserSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to register new users
|    As a user
|    I need register
|
| Scenario:
|   Given: I am a user and I have completed my registration form
|   When: I submit my results
|   Then: My account should be created
*/
namespace Tests\Feature\acceptance\http\register;

use App\User;
use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class RegisterUserSuccessTest extends AbstractHttpTestClass
{
    protected $postRoute = 'register';

    protected function setUp()
    {
        parent::setUp();
        $this->destroyUsers();
        $this->setPostResponse([
            'first_name' => 'Zack',
            'last_name' => 'Smith',
            'username' => 'Zackery',
            'email' => 'name@company.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);
    }

    /**
     *  @test
     *  @group register
     *  @group acceptance
     */
    public function it_must_be_able_to_create_a_new_user()
    {
        $user = User::first()->toArray();
        $this->assertEquals('Zack', $user['first_name']);
    }

    /**
     *  @test
     *  @group register
     *  @group acceptance
     */
    public function it_must_redirect_to_the_home_page()
    {
        $this->postResponse->assertRedirect('/');
    }
}
