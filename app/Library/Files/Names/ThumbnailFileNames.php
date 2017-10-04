<?php
/*
|--------------------------------------------------------------------------
| ThumbnailFileNames.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for receiving a file name (string) and returning
| a file with a similar name, but has _tn.(extension) at the end
*/

namespace App\Library\Files\Names;


use Illuminate\Http\UploadedFile;

class ThumbnailFileNames
{
    /**
     * returns the thumbnail file path
     *
     * @param UploadedFile $file
     * @param $path
     * @return string
     */
    public static function format(UploadedFile $file, $path)
    {
        $file = self::file($file);
        return $path . $file;
    }

    /**
     * returns the thumbnail file only
     *
     * @param UploadedFile $file
     * @return mixed
     */
    public static function file(UploadedFile $file)
    {
        $ext = $file->extension();
        $hash = $file->hashName();
        return substr_replace($hash, '_tn.' . $ext, strrpos($hash, '.'));
    }
}