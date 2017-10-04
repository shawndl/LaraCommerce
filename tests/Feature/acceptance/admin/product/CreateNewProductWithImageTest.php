<?php
/*
|--------------------------------------------------------------------------
| CreateNewProductWithImageTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to provide images of products
|    As a admin
|    I need to upload an image for a product
|
| Scenario:
|   Given: I am an admin and I fill out the new product form
|   And: I upload a new Image
|   When: I submit the form
|   Then: A new image should be saved into our system and saved in our database
*/
namespace Tests\Feature\acceptance\admin\product;

use App\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CreateNewProductWithImageTest extends AbstractNewProduct
{
    /**
     * @var bool
     */
    protected $upload = true;

    public function setUp()
    {
        parent::setUp();
        Storage::fake('public');
        $this->upload_image = UploadedFile::fake()->image('book.jpg');
        $this->upload = true;
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
}
