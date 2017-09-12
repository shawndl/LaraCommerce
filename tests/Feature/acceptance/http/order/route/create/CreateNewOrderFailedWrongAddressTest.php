<?php
/*
|--------------------------------------------------------------------------
| CreateNewOrderFailedWrongAddressTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent users from using addresses that don't belong to them
|    As a user
|    I need to order some products
|
| Scenario:
|   Given: I have just selected an address
|   And: I use another users address
|   When: I post to orders
|   Then: I should receive an error message
*/
namespace Tests\Feature\acceptance\http\order\route\create;

use App\Order;
use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateNewOrderFailedWrongAddressTest extends AbstractHttpAjaxTestClass
{
    use \SetUpAddressTrait;

    /**
     * @var integer
     */
    protected $code = 422;

    /**
     * @var array
     */
    protected $message = [
        'error' => 'Error: there is no record of this address in your account!'
    ];

    protected function setUp()
    {
        parent::setUp();
        $this->setUpAddress();
        $this->addSecondUser();
        $this->setPostResponseUser([
            'address_id' => $this->addresses[0]->id
        ], false);
    }

}
