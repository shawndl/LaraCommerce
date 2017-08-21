<?php
/*
|--------------------------------------------------------------------------
| ShoppingCartRemove.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for removing items from the shopping cart
*/

namespace App\Library\ShoppingCart;


class ShoppingCartRemove extends AbstractShoppingCart
{

    /**
     * it will remove items from the cart
     *
     * @return void
     */
    protected function processResults()
    {
        $this->findItem($this->product->id);
        $this->cart->remove($this->item->rowId);
    }

    /**
     * sets the result message for the user
     *
     * @return void
     */
    protected function setResult()
    {
        $this->result = "You removed the {$this->item->name} from your shopping cart";
    }
}