<?php
/**
 * Created by PhpStorm.
 * User: shawnlegge
 * Date: 19/10/18
 * Time: 7:16 PM
 */

namespace App\Library\Data;


class FetchJsonFile
{
    /**
     * opens file and returns content
     * @param $name
     * @return array
     */
    public static function open($name)
    {
        $path = database_path('data') . "/$name";
        if(file_exists($path))
        {
            $file = file_get_contents($path);
            return json_decode($file, true);
        }
        return [];
    }
}