<?php
/*
|--------------------------------------------------------------------------
| CheckUserNameTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to assist users in choosing a username
|    As a user
|    I need choose a user name
|
| Scenario:
|   Given: I am a user and I have selected a user name
|   When: when the browser posts to user-username-taken
|   Then: it will return either true or false
*/
namespace Tests\Feature\acceptance\http\register;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CheckUserNameTest extends AbstractHttpTestClass
{
    use \SetUpUserTrait;

    protected $postRoute = 'user-username-taken';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpUser();
    }

    /**
     *  @test
     *  @group register
     *  @group acceptance
     */
    public function if_an_email_is_taken_then_it_must_return_false()
    {
        $this->setPostResponse([
            'username' => 'candy'
        ]);
        $this->postResponse->assertJson(['username' => false]);
    }

    /**
     *  @test
     *  @group register
     *  @group acceptance
     */
    public function if_an_email_is_not_taken_then_it_must_return_true()
    {
        $this->setPostResponse([
            'username' => 'candy2'
        ]);
        $this->postResponse->assertJson(['username' => true]);
    }
}
