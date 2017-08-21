<?php
/*
|--------------------------------------------------------------------------
| CheckEmailTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to assist users in choosing a email
|    As a user
|    I need choose a email
|
| Scenario:
|   Given: I am a user and I have selected an email
|   When: when the browser posts to user-email-taken
|   Then: it will return either true or false
*/
namespace Tests\Feature\acceptance\http\register;

use App\User;
use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;

class CheckEmailTest extends AbstractHttpAjaxTestClass
{
    use \SetUpUserTrait;

    protected $postRoute = 'user-email-taken';

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
            'email' => 'email@company.com'
        ]);
        $this->postResponse->assertJson(['email' => false]);
    }

    /**
     *  @test
     *  @group register
     *  @group acceptance
     */
    public function if_an_email_is_not_taken_then_it_must_return_true()
    {
        $this->setPostResponse([
            'email' => 'email2@company.com'
        ]);
        $this->postResponse->assertJson(['email' => true]);
    }
}
