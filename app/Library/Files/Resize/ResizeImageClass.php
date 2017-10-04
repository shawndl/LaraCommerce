<?php
/*
|--------------------------------------------------------------------------
| ResizeImageClass.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for receiving a file path and resizing an image
| based on the users request
*/

namespace App\Library\Files\Resize;


use Intervention\Image\Facades\Image;

class ResizeImageClass
{
    /**
     * @var string
     */
    protected $thumbnailStorage;

    /**
     * @var string
     */
    protected $filePath;

    /**
     * @var array
     */
    protected $dimensions = [
        'height' => 0,
        'width' => 0
    ];


    /**
     * sets the file path
     *
     * @param string $filePath
     * @return $this
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
        if(file_exists($this->filePath)) return;
        $this->findPathFromURL($filePath);
        return $this;
    }

    /**
     * sets the dimensions
     *
     * @param int $height
     * @param int $width
     * @return $this
     * @throws \Exception
     */
    public function resize($height, $width)
    {
        $this->resizeImage($height, $width);
        return $this;
    }

    /**
     * sets the thumbnail path based on
     *
     * @param int $height
     * @param int $width
     * @return void
     */
    public function addThumbNail($height, $width)
    {
        $parts = pathinfo($this->filePath);
        $thumbNail = "{$parts['dirname']}/{$parts['filename']}_tn.{$parts['extension']}";
        $this->resizeImage($height, $width, $thumbNail);
    }

    /**
     * removes the host name from the path
     * then sets the path to the storage path
     *
     * @param $filePath
     */
    private function findPathFromURL($filePath)
    {
        $hostName = strlen((config('app.url')));
        $pathWithoutHost = substr($filePath, $hostName);
        $this->filePath = storage_path('app/public/' . substr($pathWithoutHost, 9));
    }

    /**
     * resizes the image and stores it in the database or throws an exception
     *
     * @param $height
     * @param $width
     * @param null|string $thumbNail
     * @throws \Exception
     */
    private function resizeImage($height, $width, $thumbNail = null)
    {
        if(!file_exists($this->filePath)) return;

        $file = (is_null($thumbNail)) ? $this->filePath : $thumbNail;
        $image = Image::make($this->filePath);
        $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save($file);
    }

}