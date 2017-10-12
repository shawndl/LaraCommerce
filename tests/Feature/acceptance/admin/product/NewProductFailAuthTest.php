<?php

namespace Tests\Feature\acceptance\admin\product;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewProductFailAuthTest extends AbstractNewProduct
{
    public function setUp()
    {
        parent::setUp();
        $this->sendRequest(false, false);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function it_must_response_with_a_302()
    {
        $this->postResponse->assertStatus(302);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function it_must_not_create_a_product()
    {
        $this->assertDatabaseMissing('products', [
            'title' => $this->post['title']
        ]);
    }
}
