<?php

namespace Tests\Feature\integration\db\transformers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderTransformerUserTest extends AbstractTestOrderTransformer
{
    protected function setUp()
    {
        parent::setUp();
        $this->resetOrderTransformerSingle(true);
    }

    /** @test */
    public function if_the_user_parameter_is_set_to_true_then_it_will_include_the_users_information()
    {
        $this->assertArrayHasKey('user', $this->orderTransformerSingle['order']);
    }

    /** @test */
    public function if_the_user_parameter_is_set_to_false_then_it_will_not_include_the_users_information()
    {
        $this->resetOrderTransformerSingle();
        $this->assertArrayNotHasKey('user', $this->orderTransformerSingle['order']);
    }

    /** @test */
    public function the_address_array_must_return_the_street_address()
    {
        $this->assertArrayHasKey('user_name', $this->orderTransformerSingle['order']['user']);
        $this->assertEquals($this->user->username, $this->orderTransformerSingle['order']['user']['user_name']);
    }

    /** @test */
    public function the_address_array_must_return_the_email()
    {
        $this->assertArrayHasKey('email', $this->orderTransformerSingle['order']['user']);
        $this->assertEquals($this->user->email, $this->orderTransformerSingle['order']['user']['email']);
    }

    /** @test */
    public function the_address_array_must_return_the_first_name()
    {
        $this->assertArrayHasKey('first_name', $this->orderTransformerSingle['order']['user']);
        $this->assertEquals($this->user->first_name, $this->orderTransformerSingle['order']['user']['first_name']);
    }

    /** @test */
    public function the_address_array_must_return_the_last_name()
    {
        $this->assertArrayHasKey('last_name', $this->orderTransformerSingle['order']['user']);
        $this->assertEquals($this->user->last_name, $this->orderTransformerSingle['order']['user']['last_name']);
    }

}
