<?php
/*
|--------------------------------------------------------------------------
| SalesTransformer.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for receiving a sale and returning an array to
| be used on the show sales screen
*/

namespace App\Library\Transformer;


use Illuminate\Database\Eloquent\Model;

class SalesTransformer extends AbstractTransformer
{
    /**
     * @var double
     */
    protected static $discountPrice;

    /**
     * returns a single address
     *
     * @param Model $sale
     * @return array
     */
    public static function single(Model $sale)
    {
        self::setDiscountPrice($sale->discount, $sale->product->price);
        return [
            'id' => $sale->id,
            'product_title' => $sale->product->title,
            'product_description' => $sale->product->description,
            'category' => $sale->product->category->name,
            'product_price' => $sale->product->price,
            'product_image' => $sale->product->image->path,
            'product_thumbnail' => $sale->product->image->thumbnail,
            'discount' =>  '%' . (int)($sale->discount * 100),
            'discount_price' => self::$discountPrice,
            'sale_start' => $sale->start,
            'sale_finish' => $sale->finish
        ];
    }

    protected static function setDiscountPrice($discount, $price)
    {
        self::$discountPrice =  number_format($price - ($discount * $price), 2);
    }
}