<?php

namespace Tests\Feature\acceptance\admin\sale;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EditSaleSuccessTest extends AbstractTestSale
{
    use \SetUpSaleTrait;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpSale();
        $this->postRoute = $this->postRoute . '/' . $this->sale->id;
        $this->post['discount'] = '0.50';
        $this->sendRequest(true);
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
            'You updated a sale!']);
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
            'discount' => '0.50'
        ]);
    }
}
