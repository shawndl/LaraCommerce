<?php

namespace Tests\Feature\acceptance\http\viewAccount\ajax;

use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetUserOrderSuccessTest extends AbstractHttpAjaxTestClass
{
    use \SetUpOrderTrait;

    protected $getRoute = '/order/invoice/';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpOrderDatabase();
        $this->getRoute = $this->getRoute . $this->orders[0]->id;
        $this->setGetResponseUser();
    }

    /**
     * @group acceptance
     * @group useraccount
     * @test
     */
    public function it_must_return_a_status_200()
    {
        $this->getResponse->assertStatus(200);
    }

    /**
     * @group acceptance
     * @group useraccount
     * @test
     */
    public function it_must_return_the_users_details()
    {
        //dd($this->getResponse->json());
        $this->getResponse->assertJsonStructure([
            'status',
            'details' => [
                'order' => [
                    'id', 'created', 'arrival', 'order_date', 'ship_date',
                    'cost' => ['total', 'sub_total', 'taxes'],
                    'user' => ['user_name', 'email', 'first_name', 'last_name'],
                    'address' => ['street_address', 'city', 'state', 'postal_code'],
                    'products' => []
                ],
            ]
        ]);
    }
}
