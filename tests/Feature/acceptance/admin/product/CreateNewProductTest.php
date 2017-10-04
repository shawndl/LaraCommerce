<?php
/*
|--------------------------------------------------------------------------
| CreateNewProductTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to add products to the database
|    As an admin
|    I need to create a new product
|
| Scenario:
|   Given: I am an administrator that is logged in
|   And: I have completed the new product form correctly
|   When: I submit my request
|   Then: A new product should be added
*/
namespace Tests\Feature\acceptance\admin\product;

use App\Image;
use App\Product;
use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateNewProductTest extends AbstractNewProduct
{
    public function setUp()
    {
        parent::setUp();
        $this->sendRequest();
    }


    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function it_must_return_a_success_message()
    {
        $this->postResponse->assertJsonFragment(['message' =>
            'You have created a new product!']);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function it_must_add_the_new_product_to_the_database()
    {
        $this->assertDatabaseHas('products', [
            'title' => 'A Book'
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
            'path' => 'http://via.placeholder.com/150x150',
            'thumbnail' => 'http://via.placeholder.com/50x50'
        ]);
    }



    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function if_the_image_path_already_exists_then_a_new_image_will_not_be_added()
    {
        $this->sendRequest();
        $imageCount = Image::count();
        $productCount = Product::count();
        $this->assertEquals(2, $productCount);
        $this->assertEquals(1, $imageCount);
    }

}
