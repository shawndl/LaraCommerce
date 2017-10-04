<?php
/*
|--------------------------------------------------------------------------
| UpdateProductWithImageTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to allow the admin to change product images
|    As a admin
|    I need to change the image of a product with an upload
|
| Scenario:
|   Given: I am an admin
|   And: I upload a new image for a product
|   When: I submit
|   Then: I must receive a success message
|   And: the image must be updated
*/
namespace Tests\Feature\acceptance\admin\product;

use App\Image;
use App\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateProductWithImageTest extends AbstractNewProduct
{
    use \SetUpImageTrait;

    public function setUp()
    {
        parent::setUp();
        $this->setUpImage();
        factory(Product::class)
            ->create(['title' => 'I-Phone', 'image_id' => $this->image->id]);
        $this->postRoute = $this->postRoute . '/' . Product::first()->id;
        Storage::fake('public');
        $this->upload_image = UploadedFile::fake()->image('book.jpg');
        $this->upload = true;
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
    public function the_image_path_must_be_added_to_the_image_table()
    {
        $this->assertDatabaseHas('images', [
            'path' => url('/storage/images/products/' . $this->upload_image->hashName())
        ]);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_image_thumbnail_must_be_added_to_the_image_table()
    {
        $thumbnail = strstr($this->upload_image->hashName(), '.jpeg', true) . '_tn.jpeg';

        $this->assertDatabaseHas('images', [
            'thumbnail' => url('/storage/images/products/' . $thumbnail)
        ]);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_file_must_be_uploaded_to_the_system()
    {
        Storage::disk('public')->assertExists('images/products/' . $this->upload_image->hashName());
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_products_image_id_must_be_the_uploaded_image_id()
    {
        $image = Image::where('path', '=',
            url('/storage/images/products/' . $this->upload_image->hashName()))->first();
        $this->assertDatabaseHas('products', ['image_id' => $image->id]);
    }
}
