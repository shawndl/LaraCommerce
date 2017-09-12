<?php

namespace Tests\Feature\acceptance\http\viewAccount\ajax;

use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;

class GetUserAccountSuccessTest extends AbstractHttpAjaxTestClass
{
    protected $getRoute = 'user/users-details';

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
    public function it_must_return_a_status_200()
    {
        $this->getResponse->assertStatus(200);
    }

    /**
     * @group acceptance
     * @group user_account
     * @test
     */
    public function it_must_return_the_users_details()
    {
        $this->getResponse->assertJsonStructure([
            'user' => ['first_name', 'last_name', 'email', 'username']
        ]);
    }
}
