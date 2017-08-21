<?php
/*
|--------------------------------------------------------------------------
| AbstractShoppingCart.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for receiving a shopping cart item and a product
| and in the child classes it will add, remove, and edit
*/

namespace App\Library\ShoppingCart;


use App\Product;
use Syscover\ShoppingCart\Cart;
use Syscover\ShoppingCart\Item;
use Syscover\ShoppingCart\TaxRule;

abstract class AbstractShoppingCart implements ShoppingCartInterface
{
    /**
     * @var integer
     */
    protected $quantity;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var Cart
     */
    protected $cart;

    /**
     * @var Item
     */
    protected $item;

    /**
     * @var TaxRule
     */
    protected $tax;

    /**
     * @var string
     */
    protected $result;

    /**
     * AbstractShoppingCart constructor.
     * @param Product $product
     * @param Cart $cart
     */
    public function __construct(Product $product, Cart $cart)
    {
        $this->product = $product;
        $this->cart = $cart;

    }

    /**
     * sets the quantity property
     *
     * @param int $quantity
     * @return void
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }


    /**
     * processes the shopping cart request and gets the result
     *
     * @return string
     */
    public function getResult()
    {
        $this->processResults();
        $this->setResult();
        return $this->result;
    }

    /**
     * sets the item property
     *
     * @param Item $item
     * @return void
     */
    protected function setItem(Item $item)
    {
        $this->item = $item;
    }

    /**
     * sets the tax rule
     *
     * @param TaxRule $taxRule
     * @return void
     */
    protected function setTax(TaxRule $taxRule)
    {
        $this->tax = $taxRule;
    }

    /**
     * searches the shopping cart to find the item that matches
     *
     * @param int $id
     * @return void
     */
    protected function findItem($id)
    {
        $item = $this->cart->search(function($cartItem) use ($id){
            return $cartItem->id === $id;
        });
        $this->setItem($item->first());
    }

    /**
     * in the child classes it will process the request
     *
     * @return
     */
    abstract protected function processResults();

    /**
     * sets the result message for the user
     *
     * @return void
     */
    abstract protected function setResult();
}