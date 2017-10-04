<?php
/*
|--------------------------------------------------------------------------
| ProductsTransformer.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for a Product object and returns an array with
| 1) category
| 2) image
| 3) title
| 4) price
| 5) description
| 6) weight
*/

namespace App\Library\Transformer;


use Illuminate\Database\Eloquent\Model;

class ProductsTransformer extends AbstractTransformer
{
    /**
     * returns a single product
     *
     * @param Model $model
     * @return array
     */
    public static function single(Model $model)
    {
        return [
            'product_id' => $model->id,
            'title' => $model->title,
            'price' => $model->price,
            'description' => $model->description,
            'weight' => $model->weight,
            'category' => $model->category()->first()->name,
            'image' => $model->image()->first()->path,
            'thumbnail' => $model->image()->first()->thumbnail
        ];
    }
}