<?php
/*
|--------------------------------------------------------------------------
| CreateNewOrderSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to create a new order
|    As a user
|    I need to order some products
|
| Scenario:
|   Given: I have just selected an address
|   And: I am logged in
|   When: I post to orders
|   Then: A new order should be created
*/
namespace Tests\Feature\acceptance\http\order\route\create;

use App\Order;
use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateNewOrderSuccessTest extends AbstractHttpAjaxTestClass
{
    use \SetUpAddressTrait;
    protected $postRoute = 'order';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpAddress();
        $this->setPostResponseUser([
            'address_id' => $this->addresses[0]->id
        ]);
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function it_must_create_a_new_order()
    {
        $count = Order::count();
        $this->assertEquals(1, $count);
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
           'message' => 'You have selected an address!'
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
