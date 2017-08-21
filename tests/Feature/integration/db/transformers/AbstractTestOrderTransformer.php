<?php

namespace Tests\Feature\integration\db\transformers;

use App\Library\Transformer\OrderTransformers;
use App\Order;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AbstractTestOrderTransformer extends TestCase
{
    use DatabaseMigrations, \SetUpOrderTrait;

    /**
     * @var array
     */
    protected $orderTransformerSingle;

    /**
     * @var Order
     */
    protected $firstOrder;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpOrderDatabase();
    }

    /**
     * resets transfomer property
     * @param boolean $address
     * @param boolean $user
     * @param boolean $product
     * @return void
     */
    protected function resetOrderTransformerSingle($user = false, $address = false, $product = false)
    {
        $this->orderTransformerSingle = OrderTransformers::single($this->orders[0], $user, $address, $product);
    }
}
