<?php

namespace Tests\Feature\acceptance\http\viewAccount\ajax;

use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetUserAccountFailedLoginTest extends AbstractHttpAjaxTestClass
{
    protected $getRoute = 'user/users-details';

    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * @group acceptance
     * @group useraccount
     * @test
     */
    public function it_must_return_a_status_401()
    {
        $this->getResponse->assertStatus(401);
    }

    /**
     * @group acceptance
     * @group useraccount
     * @test
     */
    public function it_must_return_the_users_details()
    {
        $this->getResponse->assertJson([
            'error' => 'You are not authorized to perform this request!'
        ]);
    }
}
