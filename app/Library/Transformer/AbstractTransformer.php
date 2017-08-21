<?php
/*
|--------------------------------------------------------------------------
| AbstractTransformer.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for receiving a model and returning an array
| for api calls
*/

namespace App\Library\Transformer;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractTransformer
{
    /**
     * @var array
     */
    protected static $data = [];

    /**
     * gets an array of all addresses in a collection
     *
     * @param Collection $collection
     * @return array
     */
    public static function transform(Collection $collection)
    {
        self::$data = [];
        foreach ($collection as $item)
        {
            self::$data[] = static::single($item);
        }
        return static::$data;
    }

    /**
     * in the child class it will return an array of relevant information for the class
     *
     * @param Model $model
     * @return array
     */
    public static function single(Model $model)
    {
        return [];
    }
}