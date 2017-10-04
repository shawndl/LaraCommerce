<?php
/*
|--------------------------------------------------------------------------
| ImageDatabase.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for receiving an image and either updating it
| or creating a new image
*/

namespace App\Library\Database;


use App\Image;
use Illuminate\Http\Request;

class ImageDatabase
{
    /**
     * @var Image
     */
    private static $image;

    /**
     * @var array
     */
    private static $request;

    /**
     * creates a new image and returns the new image
     *
     * @param Image $image
     * @param array $request
     * @return Image
     */
    public static function create(Image $image, array $request)
    {
        self::setProperties($image, $request);
        if(self::hasPath())
        {
            return self::createImage();
        }

    }

    /**
     * updates an existing image
     *
     * @param Image $image
     * @param array $request
     * @return Image
     */
    public static function update(Image $image, array $request)
    {
        self::setProperties($image, $request);
        if(self::hasPath())
        {
            self::$image->update(['path' => self::$request['image']]);
            return self::$image;
        }
    }

    /**
     * sets the classes properties
     *
     * @param Image $image
     * @param array $request
     * @return void
     */
    private static function setProperties(Image $image, array $request)
    {
        self::$image = $image;
        self::$request = $request;
    }

    /**
     * does the image have a path
     *
     * @return bool
     */
    private static function hasPath()
    {
        return !is_null(self::$request['image']);
    }

    /**
     * creates a new image if it does not already exist
     *
     * @return Image
     */
    private static function createImage()
    {
        $image = self::doesImageExist(new Image());
        if($image instanceof Image)
        {
            return $image;
        }
        return self::$image->create([
            'path' => self::$request['image'],
            'thumbnail' => self::$request['thumbnail']
        ]);
    }

    /**
     * checks if the image already exists in the database
     *
     * @param Image $image
     * @return bool|Image
     */
    private static function doesImageExist(Image $image)
    {
        $oldImage = $image->where('path', self::$request['image'])->first();
        if(!is_null($oldImage))
        {
            return $oldImage;
        }
        return false;
    }
}