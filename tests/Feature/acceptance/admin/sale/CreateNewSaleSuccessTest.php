<?php

namespace Tests\Feature\acceptance\admin\sale;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateNewSaleSuccessTest extends AbstractTestSale
{
    protected function setUp()
    {
        parent::setUp();
        $this->sendRequest();
    }

    /**
     * @group sales
     * @group admin
     * @group acceptance
     * @test
     */
    public function it_must_return_a_success_message()
    {
        $this->postResponse->assertJsonFragment(['message' =>
            'You have added a sale to the book product!']);
    }

    /**
     * @group sales
     * @group admin
     * @group acceptance
     * @test
     */
    public function it_must_add_the_new_product_to_the_database()
    {
        $this->assertDatabaseHas('sales', [
            'discount' => '0.25'
        ]);
    }
}
