<?php
/*
|--------------------------------------------------------------------------
| SetUpShoppingCartTrait.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for setting up a shopping cart instance
*/

use App\Product;
use Syscover\ShoppingCart\Facades\CartProvider;
use Syscover\ShoppingCart\Item;
use Syscover\ShoppingCart\TaxRule;

trait SetUpShoppingCartTrait
{
    /**
     *  adds every product to the shopping cart and applies the first tax rules
     */
    protected function setUpShoppingCart()
    {
        foreach($this->products as $product)
        {
            CartProvider::instance()
                ->add(new Item($product->id,
                    $product->title,
                    1,
                    $product->price,
                    $product->weight,
                    true,
                    new TaxRule(
                        $this->tax->name,
                        $this->tax->percent * 100)));
        }
    }

    /**
     * gets the cart items
     *
     * @return \Syscover\ShoppingCart\CartItems
     */
    public function getCartItems()
    {
        return CartProvider::instance()->getCartItems();
    }

    /**
     * returns the item of the shopping cart
     *
     * @param int $id
     * @return Item
     */
    public function findFromShoppingCart($id)
    {
        return CartProvider::instance()->search(function($cartItem) use ($id){
            return $cartItem->id === $id;
        })->first();
    }
}