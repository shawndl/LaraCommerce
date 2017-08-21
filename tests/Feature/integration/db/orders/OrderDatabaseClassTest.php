<?php

namespace Tests\Feature\integration\db\orders;

use App\Library\Order\OrderDatabase;
use App\Order;
use Carbon\Carbon;
use Syscover\ShoppingCart\Facades\CartProvider;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderDatabaseClassTest extends TestCase
{
    use DatabaseMigrations, \SetUpShoppingCartTrait, \SetUpAddressTrait, \SetUpProductsTrait;

    /**
     * @var Order
     */
    protected $order;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
        $this->setUpShoppingCart();
        $this->setUpAddress();
        $this->order = OrderDatabase::createOrder(new Order(), $this->addresses[0], $this->user);
        OrderDatabase::addPricing($this->order, CartProvider::instance());
    }

    /** @test */
    public function the_order_database_class_must_be_able_to_create_a_new_order()
    {
        $this->assertEquals(1, Order::count());
    }

    /** @test */
    public function a_new_order_must_have_an_address_id_that_matches_the_Address_object_used()
    {
        $this->assertEquals($this->order->address_id, $this->addresses[0]->id);
    }

    /** @test */
    public function a_new_order_must_have_a_user_id_that_matches_the_id_of_the_logged_in_user()
    {
        $this->assertEquals($this->order->user_id, $this->user->id);
    }

    /** @test */
    public function a_new_order_must_have_an_order_date_that_matches_today()
    {
        $this->assertEquals($this->order->order_date, Carbon::now()->format('Y-m-d h:i:s'));
    }

    /** @test */
    public function the_order_database_class_must_be_able_to_update_the_address()
    {
        OrderDatabase::updateOrder($this->order, $this->addresses[1]);
        $this->assertEquals($this->order->address_id, $this->addresses[1]->id);
    }

    /** @test */
    public function an_update_must_be_able_to_include_the_order_total()
    {
        $this->assertEquals($this->order->total, number_format(CartProvider::instance()->total, 2));
    }

    /** @test */
    public function an_update_must_be_able_to_include_the_order_sub_total()
    {
        $this->assertEquals($this->order->sub_total, number_format(CartProvider::instance()->subtotal, 2));
    }

    /** @test */
    public function an_update_must_be_able_to_include_the_order_taxes()
    {
        $this->assertEquals($this->order->taxes, number_format(CartProvider::instance()->taxAmount, 2));
    }

    /** @test */
    public function the_order_database_class_must_be_able_to_add_products_to_the_order()
    {
        OrderDatabase::addProducts($this->order, CartProvider::instance());
        $this->assertEquals(4, $this->order->products->count());
    }
}
