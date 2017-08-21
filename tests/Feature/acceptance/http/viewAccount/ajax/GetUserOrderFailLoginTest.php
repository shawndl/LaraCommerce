<?php

namespace Tests\Feature\acceptance\http\viewAccount\ajax;

use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;

class GetUserOrderFailLoginTest extends AbstractHttpAjaxTestClass
{
    use \SetUpOrderTrait;

    protected $getRoute = '/order/invoice/';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpOrderDatabase();
        $this->getRoute = $this->getRoute . $this->orders[0]->id;
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
            'error' => 'Unauthenticated.'
        ]);
    }
}
