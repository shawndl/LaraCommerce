<?php
/*
|--------------------------------------------------------------------------
| UpdateOrderFailedAddressBelongsUserTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent users from updating orders with address that don't
|       belong to them
|    As a user
|    I need update an order
|
| Scenario:
|   Given: I am updating my order
|   And: the address given does not belong to me
|   When: I submit
|   Then: I must receive an error message
*/
namespace Tests\Feature\acceptance\http\order\route\update;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateOrderFailedAddressBelongsUserTest extends AbstractFailedUpdateOrder
{
    use \SetUpOrderTrait;
    /**
     * @var integer
     */
    protected $code = 403;

    /**
     * @var string
     */
    protected $message = ['error' => 'Error: we are unable to process your request'];

    protected function setUp()
    {
        parent::setUp();
        $this->setUpAddress();
        $this->addSecondUser();
        $this->setUpOrderDatabase(true);
        $this->postRoute = 'order/' . $this->orders[0]->id;
        $this->setPostResponseUser([
            '_method' => 'PATCH',
            'address_id' => $this->addresses[0]->id
        ], false);
    }
}
