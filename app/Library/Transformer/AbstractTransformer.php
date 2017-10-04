<?php
/*
|--------------------------------------------------------------------------
| AbstractTransformer.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for receiving a model and returning an array.
| The purpose of a transformer is to separate the database query from the
| the results returned from a database query
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
     * receives a collections and returns an array from the single method in the chile classes
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
     * receives an array and
     *
     * @param array $array
     * @return array
     */
    public static function transformArray(array $array)
    {
        self::$data = [];
        foreach ($array as $item)
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