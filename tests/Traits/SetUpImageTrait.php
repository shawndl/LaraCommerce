<?php

/**
 * Created by PhpStorm.
 * User: shawnlegge
 * Date: 10/8/17
 * Time: 10:43 AM
 */
trait SetUpImageTrait
{
    /**
     * @var \App\Image
     */
    protected $image;

    public function setUpImage()
    {
        $this->image = \App\Image::create([
            'path' => 'http://lorempixel.com/400/200'
        ]);
    }
}