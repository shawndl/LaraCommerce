<?php
/*
|--------------------------------------------------------------------------
| ShoppingCartTransformer.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for receiving a collection of shopping cart
| items and returning an array of product information
*/

namespace App\Library\Transformer;


use App\Product;
use Syscover\ShoppingCart\Facades\CartProvider;
use Syscover\ShoppingCart\Item;

class ShoppingCartTransformer
{
    /**
     * get an array of shopping cart information and
     *
     * @return array
     */
    public static function transform()
    {
        $array['information'] = self::getTotal();
        $array['products'] = self::getProducts();
        return $array;
    }

    /**
     * set total amount
     *
     * @return array
     */
    protected static function getTotal()
    {
        return [
            'sub_total' => money_format('%.2n', CartProvider::instance()->subtotal),
            'total' => money_format('%.2n', CartProvider::instance()->total),
            'taxes' => money_format('%.2n', CartProvider::instance()->taxAmount),
            'count' =>  CartProvider::instance()->getCartItems()->count()
        ];
    }

    /**
     * gets all product information by querying each product and returning a product transformer
     *
     * @return array
     */
    protected static function getProducts()
    {
        $array = [];
        if(CartProvider::instance()->getCartItems()->count() > 0)
        {
            foreach (CartProvider::instance()->getCartItems() as $item)
            {
                 $array[] = [
                     'id' => $item->id,
                     'title' => $item->name,
                     'price' => money_format('%i', $item->subtotal),
                     'taxes' => money_format('%i', $item->taxAmount),
                     'total' => money_format('%i', $item->total),
                     'quantity' => $item->quantity,
                     'weight' => number_format($item->weight, 2),
                     'image' => self::getImage(Product::findOrFail($item->id))
                 ];
            }
        }
        return $array;
    }

    /**
     * returns the image path
     *
     * @param Product $product
     * @return string
     */
    private static function getImage(Product $product)
    {
        return $product->image()->first()->path;
    }
}