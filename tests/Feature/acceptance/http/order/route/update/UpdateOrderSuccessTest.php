<?php
/*
|--------------------------------------------------------------------------
| UpdateOrderSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to help users update their orders
|    As a user
|    I need update my order
|
| Scenario:
|   Given: I want to update my order
|   When: post to orders update
|   Then: Lara-Commerce must update my order
*/
namespace Tests\Feature\acceptance\http\order\route\update;


use App\Order;
use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;

class UpdateOrderSuccessTest extends AbstractHttpAjaxTestClass
{
    use \SetUpOrderTrait;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpAddress();
        $this->setUpOrderDatabase(true);
        $this->postRoute = 'order/' . $this->orders[0]->id;
        $this->setPostResponseUser([
            '_method' => 'PATCH',
            'address_id' => $this->addresses[1]->id
        ]);
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function it_must_update_the_order()
    {
        $order = Order::first();
        $this->assertEquals($this->addresses[1]->id,
            $order->address_id);
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function it_must_return_a_status_code_of_200()
    {
        $this->postResponse->assertStatus(200);
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function it_must_return_an_address_order_and_message_in_an_object()
    {
        $this->postResponse->assertJsonStructure([
            'message',
            'order' => [
                'order_id',
                'address' => ['id', 'street_address', 'city', 'state', 'state_id', 'postal_code'],
                'user' => ['first_name', 'last_name', 'email', 'username']
            ]
        ]);
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function it_must_return_a_success_message()
    {
        $this->postResponse->assertJsonFragment([
            'message' => 'You have updated your address!'
        ]);
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function it_must_have_an_order_session()
    {
        $this->postResponse->assertSessionHas('user_order');
    }
}
