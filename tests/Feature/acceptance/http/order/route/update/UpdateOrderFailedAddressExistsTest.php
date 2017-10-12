<?php
/*
|--------------------------------------------------------------------------
| UpdateOrderFailedAddressExistsTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent users from updating orders with address that don't
|       exist
|    As a user
|    I need update an order
|
| Scenario:
|   Given: I am updating my order
|   And: the address given does not exist
|   When: I submit
|   Then: I must receive an error message
*/
namespace Tests\Feature\acceptance\http\order\route\update;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateOrderFailedAddressExistsTest extends AbstractFailedUpdateOrder
{
    use \SetUpOrderTrait;
    /**
     * @var integer
     */
    protected $code = 422;

    /**
     * @var string
     */
    protected $message = ['error' => 'Sorry there was an error processing your.  Please try again'];

    protected function setUp()
    {
        parent::setUp();
        $this->setUpOrderDatabase(true);
        $this->postRoute = 'order/' . $this->orders[0]->id;
        $this->setPostResponseUser([
            '_method' => 'PATCH',
            'address_id' => 33
        ], true);
    }
}
