<?php

namespace Tests\Feature\integration\db\orders;

use App\Order;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderModelTest extends TestCase
{
    use DatabaseMigrations, \SetUpOrderTrait;

    public function setUp()
    {
        parent::setUp();
        $this->setUpOrderDatabase();
    }

    /**
     * @test
     * @group integration
     * @group models
     */
    public function it_must_be_able_to_check_if_an_order_belongs_to_the_user_logged_in()
    {
        $userID = $this->orders[0]->user_id;
        $this->assertTrue($this->orders[0]->belongsToUser($userID));
        $this->assertFalse($this->orders[0]->belongsToUser(8));
    }

    /**
     * @test
     * @group integration
     * @group models
     */
    public function it_must_be_able_to_format_the_price_to_cents()
    {
        $this->assertEquals(1845, $this->orders[0]->formatTotalCents());
    }

    /**
     * @test
     * @group integration
     * @group models
     */
    public function it_must_be_able_to_format_the_order_date()
    {
        $this->assertEquals('1st Jun, 2017', $this->orders[0]->formatOrderDate());
    }

    /**
     * @test
     * @group integration
     * @group models
     */
    public function it_must_be_able_to_format_the_ship_date()
    {
        $this->assertEquals('5th Jun, 2017', $this->orders[0]->formatShipDate());
    }
}
