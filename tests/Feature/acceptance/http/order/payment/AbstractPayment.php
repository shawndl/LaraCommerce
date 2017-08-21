<?php
/*
|--------------------------------------------------------------------------
| AbstractPayment.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for attempting to pay a stripe fee and checking
| the response.  Details about the type of scenario and response desired can
| be found in the child class.
*/
namespace Tests\Feature\acceptance\http\order\payment;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class AbstractPayment extends TestCase
{
    use DatabaseMigrations, \StripePaymentTrait,
        \SetUpOrderTrait, \SetUpShoppingCartTrait;

    /**
     * type of card
     *
     * @var string
     */
    protected $cardResponse;

    /**
     * http response type
     *
     * @var int
     */
    protected $status;

    /**
     * json response message about the status of the payment
     *
     * @var string
     */
    protected $message;

    /**
     * should the final result be yes it was paid for or no it wasn't
     *
     * @var boolean
     */
    protected $paidFor;

    /**
     * @var TestResponse
     */
    protected $response;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpOrderDatabase(true);
        $this->setUpProduct();
        $this->setUpShoppingCart();
        $this->{$this->cardResponse}();
        $this->setUpToken();
    }

    /**
     *  @test
     *  @group live_payment
     *  @group acceptance
     */
    public function the_payment_must_provide_the_correct_response()
    {
        // The order should begin by not being paid for
        $this->assertDatabaseHas('orders', [
            'paid_for' => 0
        ]);

        $this->setUpResponse();

        // The controller should respond
        $this->response->assertStatus($this->status)
            ->assertJson([
                'status' => $this->message
            ]);

        // The database should not indicate that the item is paid for
        $this->assertDatabaseHas('orders', [
            'paid_for' => $this->paidFor
        ]);
    }

    /**
     *  @test
     *  @group live_payment
     *  @group acceptance
     */
    public function if_the_payment_is_successful_then_products_should_be_added_to_the_orders_products_table()
    {
        $this->setUpResponse();
        if($this->paidFor === 1)
        {
            $this->assertDatabaseHas('order_product', [
                'order_id' => $this->orders[0]->id,
                'product_id' => $this->products[0]->id
            ]);

            $this->assertDatabaseHas('order_product', [
                'product_id' => $this->products[1]->id
            ]);

            $this->assertDatabaseHas('order_product', [
                'product_id' => $this->products[2]->id
            ]);

            $this->assertDatabaseHas('order_product', [
                'product_id' => $this->products[3]->id
            ]);

        } else {
            $this->assertDatabaseMissing('order_product', [
                'order_id' => $this->orders[0]->id,
                'product_id' => $this->products[0]->id
            ]);

            $this->assertDatabaseMissing('order_product', [
                'product_id' => $this->products[1]->id
            ]);

            $this->assertDatabaseMissing('order_product', [
                'product_id' => $this->products[2]->id
            ]);

            $this->assertDatabaseMissing('order_product', [
                'product_id' => $this->products[3]->id
            ]);
        }
    }

    protected function setUpResponse()
    {
        // If the user posts
        $this->response = $this->actingAs($this->user)
            ->json('POST', '/order/billing-form', [
                'stripeEmail' => $this->user->email,
                'stripeToken' => $this->token,
                'order_id'    => $this->orders[0]->id
            ]);
    }
}
