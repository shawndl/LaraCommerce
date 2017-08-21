<?php

namespace Tests\Feature\integration\db\transformers;

use App\Library\Transformer\UserAccountTransformer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserAccountTransformerTest extends TestCase
{
    use DatabaseMigrations, \SetUpOrderTrait;

    /**
     * @var array
     */
    protected $accountTransformer;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpOrderDatabase();
        $this->accountTransformer = UserAccountTransformer::transform($this->user);
    }

    /** @test */
    public function the_array_must_return_the_users_details()
    {
        $this->assertArrayHasKey('user', $this->accountTransformer);
    }

    /** @test */
    public function the_array_must_return_the_users_first_name()
    {
        $this->assertArrayHasKey('first_name', $this->accountTransformer['user']);
        $this->assertEquals($this->user->first_name, $this->accountTransformer['user']['first_name']);
    }

    /** @test */
    public function the_array_must_return_the_users_last_name()
    {
        $this->assertArrayHasKey('last_name', $this->accountTransformer['user']);
        $this->assertEquals($this->user->last_name, $this->accountTransformer['user']['last_name']);
    }

    /** @test */
    public function the_array_must_return_the_users_email_name()
    {
        $this->assertArrayHasKey('email', $this->accountTransformer['user']);
        $this->assertEquals($this->user->email, $this->accountTransformer['user']['email']);
    }

    /** @test */
    public function the_array_must_return_the_users_username()
    {
        $this->assertArrayHasKey('username', $this->accountTransformer['user']);
        $this->assertEquals($this->user->username, $this->accountTransformer['user']['username']);
    }

    /** @test */
    public function the_array_must_return_the_address_details()
    {
        $this->assertArrayHasKey('addresses', $this->accountTransformer);
    }

    /** @test */
    public function the_array_must_return_all_the_addresses()
    {
        $this->assertCount(3, $this->accountTransformer['addresses']);
    }

    /** @test */
    public function it_must_return_the_state()
    {
        $this->assertContains('Colorado', $this->accountTransformer['addresses'][0]);
        $this->assertArrayHasKey('state', $this->accountTransformer['addresses'][0]);
    }

    /** @test */
    public function it_must_return_the_city()
    {
        $this->assertContains('Springfield', $this->accountTransformer['addresses'][0]);
        $this->assertArrayHasKey('city', $this->accountTransformer['addresses'][0]);
    }

    /** @test */
    public function it_must_return_the_street_address()
    {
        $this->assertContains('123 Fake St.', $this->accountTransformer['addresses'][0]);
        $this->assertArrayHasKey('street_address', $this->accountTransformer['addresses'][0]);
    }

    /** @test */
    public function it_must_return_the_postal_code()
    {
        $this->assertContains('27299', $this->accountTransformer['addresses'][0]);
        $this->assertArrayHasKey('postal_code', $this->accountTransformer['addresses'][0]);
    }
    
    /** @test */
    public function the_array_must_return_all_the_orders()
    {
        $this->assertCount(2, $this->accountTransformer['orders']);
    }

    /** @test */
    public function it_must_return_the_order_id()
    {
        $this->assertArrayHasKey('id', $this->accountTransformer['orders'][0]['order']);
        $this->assertEquals($this->orders[0]->id, $this->accountTransformer['orders'][0]['order']['id']);
    }

    /** @test */
    public function it_must_return_if_the_order_was_created()
    {
        $this->assertArrayHasKey('created', $this->accountTransformer['orders'][0]['order']);
        $this->assertTrue($this->accountTransformer['orders'][0]['order']['created']);
    }

    /** @test */
    public function it_must_return_the_estimated_arrival_date()
    {
        $this->assertArrayHasKey('arrival', $this->accountTransformer['orders'][0]['order']);
    }

    /** @test */
    public function it_must_return_the_order_date()
    {
        $this->assertArrayHasKey('order_date', $this->accountTransformer['orders'][0]['order']);
        $this->assertEquals($this->orders[0]->formatOrderDate(),
            $this->accountTransformer['orders'][0]['order']['order_date']);
    }

    /** @test */
    public function if_the_ship_date_is_set_then_it_must_return_the_ship_date()
    {
        $this->assertArrayHasKey('ship_date', $this->accountTransformer['orders'][0]['order']);
        $this->assertEquals($this->orders[0]->formatShipDate(),
            $this->accountTransformer['orders'][0]['order']['ship_date']);
    }

    /** @test */
    public function it_must_return_the_order_total()
    {
        $this->assertArrayHasKey('total', $this->accountTransformer['orders'][0]['order']['cost']);
        $this->assertEquals(18.45, $this->accountTransformer['orders'][0]['order']['cost']['total']);
    }

    /** @test */
    public function it_must_return_the_order_subtotal()
    {
        $this->assertArrayHasKey('sub_total', $this->accountTransformer['orders'][0]['order']['cost']);
        $this->assertEquals(16.45, $this->accountTransformer['orders'][0]['order']['cost']['sub_total']);
    }

    /** @test */
    public function it_must_return_the_order_taxes()
    {
        $this->assertArrayHasKey('taxes', $this->accountTransformer['orders'][0]['order']['cost']);
        $this->assertEquals(2.00, $this->accountTransformer['orders'][0]['order']['cost']['taxes']);
    }
}
