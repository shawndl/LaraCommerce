<?php
/*
|--------------------------------------------------------------------------
| ShoppingCartInterface.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class must be able to set the quantity and get the result
*/

namespace App\Library\ShoppingCart;


interface ShoppingCartInterface
{
    /**
     * sets the quantiy
     *
     * @param int $quantity
     * @return void
     */
    public function setQuantity($quantity);

    /**
     * gets the result
     *
     * @return string
     */
    public function getResult();
}