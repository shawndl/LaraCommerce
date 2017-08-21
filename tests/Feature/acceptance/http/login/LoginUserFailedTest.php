<?php

namespace Tests\Feature\acceptance\http\login;

use Illuminate\Support\Facades\Auth;
use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class LoginUserFailedTest extends AbstractHttpTestClass
{
    protected $postRoute = 'login';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpUser();
        $this->setPostResponse([
            'email' => 'email@company.com',
            'password' => 'password' //password is secret
        ]);
    }

    /**
     *  @test
     *  @group login
     *  @group acceptance
     */
    public function it_must_not_log_in_the_user()
    {
        $this->assertFalse(Auth::check());
    }

    /**
     *  @test
     *  @group login
     *  @group acceptance
     */
    public function it_must_return_an_error_message()
    {
        $error = session('errors');
        $this->assertEquals('These credentials do not match our records.',
            $error->get('email')[0]);
    }
}
