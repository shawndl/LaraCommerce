<?php
/**
 * Created by PhpStorm.
 * User: shawnlegge
 * Date: 15/8/17
 * Time: 12:37 PM
 */

namespace App\Library\ShoppingCart;


use Syscover\ShoppingCart\Item;
use Syscover\ShoppingCart\TaxRule;

class ShoppingCartAdd extends AbstractShoppingCart
{
    /**
     * add an item to the cart
     *
     * @return void
     */
    protected function processResults()
    {
        $this->findTax();
        $this->setItem(
            new Item($this->product->id, $this->product->title, $this->quantity,
                $this->product->price, $this->product->weight, true, $this->tax));
        $this->cart->add($this->item);
    }

    /**
     * finds the tax related to the product and sets the tax rule
     *
     * @return void
     */
    protected function findTax()
    {
        $tax = $this->product->tax()->first();
        $this->setTax(new TaxRule($tax->name, $tax->percent * 100));
    }

    /**
     * sets the result message
     *
     * @return void
     */
    protected function setResult()
    {
        $this->result = "You added {$this->product->title} to your cart!";
    }
}