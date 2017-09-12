<?php
/*
|--------------------------------------------------------------------------
| CreateNewOrderFailedValidationTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to receive accurate information
|    As a user
|    I need to order some products
|
| Scenario:
|   Given: I have just selected an address
|   And: I have provided bad information for the user id
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

class CreateNewOrderFailedValidationTest  extends AbstractFailedOrder
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
        "address_id" => [
            "The address id must be a number."
        ]
    ];


    protected function setUp()
    {
        parent::setUp();
        $this->setUpAddress();
        $this->setPostResponseUser([
            'address_id' => 'candy'
        ]);
    }
}
