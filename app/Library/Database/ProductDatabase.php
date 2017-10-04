<?php
/*
|--------------------------------------------------------------------------
| ProductDatabase.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for receiving a product and either updating it
| or creating a new product
*/

namespace App\Library\Database;


use App\Http\Requests\ProductFormRequest;
use App\Product;

class ProductDatabase
{
    /**
     * @var array
     */
    private static $request;

    /**
     * @var integer
     */
    private static $imageID;

    /**
     * creates a new product
     *
     * @param Product $product
     * @param string $imageID
     * @param array $request
     * @return Product
     */
    public static function create(Product $product, $imageID, array $request)
    {
        self::addProperties($imageID, $request);
        return $product->create(self::getRequestValues());
    }

    /**
     * @param Product $product
     * @param $imageID
     * @param array $request
     * @return Product
     */
    public static function update(Product $product, $imageID, array $request)
    {
        self::addProperties($imageID, $request);
        $product->update(self::getRequestValues());
        return $product;
    }

    /**
     * sets the properties of the class
     *
     * @param string $imageID
     * @param array $request
     * @return void
     */
    private static function addProperties($imageID, array $request)
    {
        self::$imageID = $imageID;
        self::$request = $request;
    }

    /**
     * returns a formatted array that matches the products table
     *
     * @return array
     */
    private static function getRequestValues()
    {
        return [
            'title' => self::$request['title'],
            'description' => self::$request['description'],
            'category_id' => self::$request['category'],
            'tax_id' => self::$request['tax'],
            'price' => self::$request['price'],
            'weight' => self::$request['weight'],
            'image_id' => self::$imageID
        ];
    }
}