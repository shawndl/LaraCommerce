<?php
/*
|--------------------------------------------------------------------------
| ProductDBProcessor.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for receiving an image, product, and the request
| and creating a new product.  A product must have an image so it must also
| create an image.  The user may choose to upload an image or provide a url
| to the image.
| If the user uploads an image then the processor must upload the image and
| resize it and create a thumbnail
*/

namespace App\Library\Database\Processors;


use App\Image;
use App\Library\Database\ImageDatabase;
use App\Library\Database\ImageUploadDatabase;
use App\Library\Database\ProductDatabase;
use App\Library\Files\Names\ThumbnailFileNames;
use App\Library\Files\Resize\ResizeImageClass;
use App\Product;
use Illuminate\Http\Request;

class ProductDBProcessor
{
    /**
     * @var ResizeImageClass
     */
    protected $resize;

    public function __construct(ResizeImageClass $resize)
    {
        $this->resize = $resize;
    }

    /**
     * creates a new product
     *
     * @param Product $product
     * @param Image $image
     * @param Request $request
     * @return Product
     */
    public function create(Product $product, Image $image, Request $request)
    {
        if(isset($request->image))
        {
            $image = ImageDatabase::create($image, $request->all());
        } else {
            $image = $this->uploadImage($request, $image);
        }

        return ProductDatabase::create($product, $image->id, $request->all());

    }

    /**
     * processes a new product
     * It will also determine if a the image is a image upload or link
     *
     * @param Product $product
     * @param Image $image
     * @param Request $request
     * @return void
     */
    public function update(Product $product, Image $image, Request $request)
    {
        if(isset($request->image) && $image->path !== $request->image)
        {
            $image = ImageDatabase::create($image, $request->all());
        } elseif(!is_null($request->file('upload'))) {
            $image = $this->uploadImage($request, $image);
        }
        ProductDatabase::update($product, $image->id, $request->all());
    }

    /**
     * uploads the image and re-sizes it
     *
     * @param $request
     * @param $image
     * @return Image
     */
    protected function uploadImage($request, $image)
    {
        $thumbnail = ThumbnailFileNames::format($request->file('upload'), '/storage/images/products/');
        $image = ImageUploadDatabase::create($image, $request->file('upload'), $thumbnail, 'images/products', '/storage/');
        $this->resize->setFilePath($image->path)
            ->resize(null, 400)
            ->addThumbNail(null, 200);
        return $image;
    }
}