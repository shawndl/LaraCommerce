<?php

namespace Tests\Feature\acceptance\admin\product;

use App\Product;

class UpdateProductFailAuthTest extends AbstractNewProduct
{
    use \SetUpImageTrait;

    public function setUp()
    {
        parent::setUp();
        $this->setUpImage();
        factory(Product::class)->create(['title' => 'I-Phone']);
        $this->postRoute = $this->postRoute . '/' . Product::first()->id;
        $this->post['title'] = 'Candy';
        $this->sendRequest(true, false);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function it_must_return_a_status_of_302()
    {
        $this->postResponse->assertStatus(302);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function it_must_not_update_the_product_to_the_database()
    {
        $this->assertDatabaseHas('products', [
            'title' => 'I-Phone'
        ]);
        $this->assertDatabaseMissing('products', [
            'title' => 'Candy'
        ]);
    }
}
