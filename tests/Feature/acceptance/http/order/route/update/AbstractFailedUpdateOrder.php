<?php

namespace Tests\Feature\acceptance\http\order\route\update;

use App\Order;
use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;

class AbstractFailedUpdateOrder extends AbstractHttpAjaxTestClass
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
     *  @test
     *  @group order
     *  @group acceptance
     */
    public function it_must_not_update_the_order()
    {
        $this->assertEquals($this->addresses[0]->id,
            $this->orders[0]->address_id);
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
