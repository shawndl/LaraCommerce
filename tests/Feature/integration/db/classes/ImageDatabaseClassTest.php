<?php

namespace Tests\Feature\integration\db\classes;


use App\Image;
use App\Library\Database\ImageDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ImageDatabaseClassTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @var Image
     */
    protected $image;

    public function setUp()
    {
        parent::setUp();
        $this->image = ImageDatabase::create(new Image(), [
            'image' => 'http://via.placeholder.com/150x150'
        ]);
    }

    /** @test */
    public function it_must_be_able_to_create_a_new_image_with_an_image_path()
    {
        $this->assertDatabaseHas('images', [
            'path' => 'http://via.placeholder.com/150x150'
        ]);
        $this->assertEquals(1, Image::count());
    }

    /** @test */
    public function if_the_path_already_exists_then_it_will_not_create_a_new_image_and_will_return_matching_image()
    {
        $image2 = ImageDatabase::create(new Image(), [
            'image' => 'http://via.placeholder.com/150x150'
        ]);
        $this->assertDatabaseHas('images', [
            'path' => 'http://via.placeholder.com/150x150'
        ]);
        $this->assertEquals(1, Image::count());
    }

    /** @test */
    public function it_must_be_able_to_create_a_new_image_with_an_image_upload()
    {

    }

    /** @test */
    public function it_must_return_the_new_image()
    {
        $image2 = ImageDatabase::create(new Image(), [
            'image' => 'http://via.placeholder.com/150x150'
        ]);
        $this->assertInstanceOf(Image::class, $image2);
    }
    
    /** @test */
    public function it_must_be_able_to_update_the_image_path()
    {
        $image = ImageDatabase::update(Image::first(), [
            'image' => 'https://dummyimage.com/600x400/000/fff'
        ]);
        $this->assertEquals('https://dummyimage.com/600x400/000/fff', $image->path);
        $this->assertEquals(1, Image::count());
    }
}
