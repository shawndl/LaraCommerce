<?php

namespace Tests\Feature\acceptance\http\login;

use Illuminate\Support\Facades\Auth;
use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class LoginUserFailedValidationTest extends AbstractHttpTestClass
{
    protected $postRoute = 'login';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpUser();
    }

    /**
     *  @test
     *  @group login
     *  @group acceptance
     */
    public function it_must_have_an_email()
    {
        $this->setPostResponse([
            'email' => '',
            'password' => 'password'
        ]);
        $error = session('errors')->get('email');
        $this->assertEquals('The email field is required.', $error[0]);
        $this->assertFalse(Auth::check());
    }

    /**
     *  @test
     *  @group login
     *  @group acceptance
     */
    public function it_must_have_a_password()
    {
        $this->setPostResponse([
            'email' => 'email@company.com',
            'password' => ''
        ]);
        $error = session('errors')->get('password');
        $this->assertEquals('The password field is required.', $error[0]);
        $this->assertFalse(Auth::check());
    }
}