<?php
/*
|--------------------------------------------------------------------------
| CreateNewOrderFailedAddressNotFoundTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to provide proper error messages
|    As a user
|    I need to order some products
|
| Scenario:
|   Given: I have just selected an address
|   And: The address does not exist
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

class CreateNewOrderFailedAddressNotFoundTest extends AbstractFailedOrder
{
    use \SetUpAddressTrait;

    /**
     * @var integer
     */
    protected $code = 422;

    /**
     * @var string
     */
    protected $message = ['error' => 'There was an error processing your request!  Please try again.'];

    protected function setUp()
    {
        parent::setUp();
        $this->setPostResponseUser([
            'address_id' => 22
        ]);
    }
}
