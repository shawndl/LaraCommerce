<?php

namespace Tests\Feature\acceptance\http\order\route\create;

use App\Order;
use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;

class AbstractFailedOrder extends AbstractHttpAjaxTestClass
{
    /**
     * @var integer
     */
    protected $code;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $postRoute = 'order';

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function it_must_not_create_a_new_order()
    {
        $count = Order::count();
        $this->assertEquals(0, $count);
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function it_must_return_a_status_code_the_correct_status_code()
    {
        $this->postResponse->assertStatus($this->code);
    }

    /**
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function it_must_return_an_error_message()
    {
        $this->postResponse->assertJson($this->message);
    }
}
