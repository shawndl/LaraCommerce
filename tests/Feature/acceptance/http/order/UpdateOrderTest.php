<?php
/*
|--------------------------------------------------------------------------
| UpdateOrderTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to update an existing order
|    As a user
|    I need resubmit my order
|
| Scenario:
|   Given: I selected a different address
|   When: I submit to http::host.com\order ( User\API\OrderController@update)
|   Then: The orders
*/
namespace Tests\Feature\acceptance\http\order;

use App\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateOrderTest extends TestCase
{
    use DatabaseMigrations, \SetUpOrderTrait;

    /**
     * @var array
     */
    protected $post = [];

    /**
     * @var integer
     */
    protected $orderID;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpOrderDatabase(true);
        $this->addSecondUser();
        $this->setUpPost($this->addresses[1]->id);
        $this->orderID = $this->orders[0]->id;
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function post_an_updated_order_test()
    {
        $response = $this->actingAs($this->user)
            ->json('POST', '/order/' . $this->orderID, $this->post);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Your order has been updated!'
            ]);

        $this->assertDatabaseHas('orders', [
            'address_id' => $this->addresses[1]->id
        ]);

        $this->assertDatabaseMissing('orders', [
            'address_id' => $this->addresses[0]->id
        ]);
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function the_user_must_be_logged_in()
    {
        $response = $this->json('POST', '/order/', $this->post);

        $response->assertStatus(405);

        $this->assertDatabaseHas('orders', [
            'address_id' => $this->addresses[0]->id
        ]);

        $this->assertDatabaseMissing('orders', [
            'address_id' => $this->addresses[1]->id
        ]);
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function the_order_must_exist()
    {
        $response = $this->actingAs($this->user)
            ->json('POST', '/order/' . 1001, $this->post);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Error: The order number provided does not match our system'
            ]);

        $this->assertDatabaseHas('orders', [
            'address_id' => $this->addresses[0]->id
        ]);

        $this->assertDatabaseMissing('orders', [
            'address_id' => $this->addresses[1]->id
        ]);
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function the_order_must_belong_to_the_user()
    {
        $response = $this->actingAs($this->secondUser)
            ->json('POST', '/order/' . $this->orderID, $this->post);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Error: The order does not belong to the user!'
            ]);

        $this->assertDatabaseHas('orders', [
            'address_id' => $this->addresses[0]->id
        ]);

        $this->assertDatabaseMissing('orders', [
            'address_id' => $this->addresses[1]->id
        ]);
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function the_address_must_belong_to_the_user()
    {
        $this->addresses[1]->user_id = $this->secondUser->id;
        $this->post['address_id'] =  $this->addresses[1]->id;

        $response = $this->actingAs($this->secondUser)
            ->json('POST', '/order/' . $this->orderID, $this->post);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Error: The order does not belong to the user!'
            ]);

        $this->assertDatabaseHas('orders', [
            'address_id' => $this->addresses[0]->id
        ]);

        $this->assertDatabaseMissing('orders', [
            'address_id' => $this->addresses[1]->id
        ]);
    }

    private function setUpPost($address)
    {
        $this->post =[
            '_method' => 'PATCH',
            '_token' => csrf_token(),
            'address_id' => $address
        ];
    }
}
