<?php
/*
|--------------------------------------------------------------------------
| ImageUploadDatabase.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for receiving an Image object and a file upload
| and updating it in the system
*/

namespace App\Library\Database;


use App\Image;
use App\Library\Files\Names\ThumbnailFileNames;
use Illuminate\Http\UploadedFile;

class ImageUploadDatabase
{
    /**
     * saves a new image upload to the database
     *
     * @param Image $image
     * @param UploadedFile $file
     * @param string $thumbnail
     * @param string $previous
     * @param $path
     * @return Image
     */
    public static function create(Image $image, UploadedFile $file, $thumbnail, $previous, $path)
    {
        $imagePath = $path . $file->store($previous, 'public');
        return $image->create([
            'path' => url($imagePath),
            'thumbnail' => url($thumbnail)
        ]);
    }
}