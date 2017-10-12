<?php

namespace Tests\Feature\acceptance\admin\product;


use App\Product;

class UpdateProductFailProductNotExitTest extends AbstractNewProduct
{
    use \SetUpImageTrait;

    public function setUp()
    {
        parent::setUp();
        $this->setUpImage();
        factory(Product::class)->create(['title' => 'I-Phone']);
        $this->postRoute = $this->postRoute . '/12';
        $this->post['title'] = 'Candy';
        $this->sendRequest(true);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function it_must_return_a_422_code()
    {
        $this->postResponse->assertStatus(404);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function it_must_not_update_the_product_to_the_database()
    {
        $this->assertDatabaseMissing('products', [
            'title' => 'Candy'
        ]);

        $this->assertDatabaseHas('products', [
            'title' => 'I-Phone'
        ]);
    }
}
