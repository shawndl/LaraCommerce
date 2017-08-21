<?php
/*
|--------------------------------------------------------------------------
| CreateNewOrderTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to create a new order
|    As a user
|    I need submit my order
|
| Scenario:
|   Given: I have an order
|   When: I submit to http::host.com\order ( User\API\OrderController@store)
|   Then: A new order should be created
*/

namespace Tests\Feature\acceptance\http\order;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateNewOrderTest extends TestCase
{
    use DatabaseMigrations, \SetUpAddressTrait;

    /**
     * @var array
     */
    protected $post = [];

    protected function setUp()
    {
        parent::setUp();
        $this->setUpAddress();
        $this->addSecondUser();
        $this->setPost();
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function post_a_new_order_test()
    {
        $response = $this->actingAs($this->user)
            ->json('POST', '/order', $this->post);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Your order has been created!'
            ]);
        $this->assertDatabaseHas('orders', [
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
        $response = $this->json('POST', '/order', $this->post);

        $response->assertStatus(401);

        $this->assertDatabaseMissing('orders', [
            'address_id' => $this->addresses[0]->id
        ]);
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function an_order_must_have_an_address()
    {
        $response = $this->actingAs($this->user)
            ->json('POST', '/order', [
               ' _token' => csrf_token()
            ]);

        $response->assertStatus(422)
            ->assertJson([
                'address_id' => [
                    "The address id field is required."
                ]
            ]);
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function the_address_must_exist_in_the_database()
    {
        $response = $this->actingAs($this->user)
            ->json('POST', '/order', [
                'address_id' => 10001,
                '_token' => csrf_token()
            ]);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Error: The address you provided was not found in our system'
            ]);

        $this->assertDatabaseMissing('orders', [
            'address_id' => 1001
        ]);
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function the_address_must_belong_to_the_user()
    {
        $response = $this->actingAs($this->secondUser)
            ->json('POST', '/order', $this->post);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Error: This address does not belong to the user logged in'
            ]);

        $this->assertDatabaseMissing('orders', [
            'address_id' => $this->addresses[0]->id
        ]);
    }

    private function setPost()
    {
        $this->post = [
            'address_id' => $this->addresses[0]->id,
            '_token' => csrf_token()
        ];
    }
}
