<?php

namespace Tests\Feature\integration\shoppingcart;

use App\Library\ShoppingCart\ShoppingCartInterface;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AbstractShoppingCart extends TestCase
{
    use DatabaseMigrations, \SetUpShoppingCartTrait, \SetUpProductsTrait;

    /**
     * @var ShoppingCartInterface
     */
    protected $shoppingCart;

    /**
     * @var string
     */
    protected $message;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
    }
}
