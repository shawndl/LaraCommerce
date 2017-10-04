<?php

namespace Tests\Feature\acceptance\admin\product;

use App\Image;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateProductSuccessTest extends AbstractNewProduct
{
    use \SetUpImageTrait;

    public function setUp()
    {
        parent::setUp();
        $this->setUpImage();
        factory(Product::class)->create(['title' => 'I-Phone']);
        $this->postRoute = $this->postRoute . '/' . Product::first()->id;
        $this->post['title'] = 'Candy';
        $this->sendRequest(true);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function it_must_return_a_success_message()
    {
        $this->assertEquals(1, Product::count());
        $this->postResponse->assertJsonFragment(['message' =>
            'You have updated the product!']);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function it_must_update_the_product_to_the_database()
    {
        $this->assertDatabaseHas('products', [
            'title' => 'Candy'
        ]);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_image_path_must_be_added_to_the_image_table()
    {
        $this->assertDatabaseHas('images', [
            'path' => 'http://via.placeholder.com/150x150'
        ]);
    }
}
