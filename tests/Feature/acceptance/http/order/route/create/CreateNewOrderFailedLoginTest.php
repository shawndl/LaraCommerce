<?php
/*
|--------------------------------------------------------------------------
| CreateNewOrderFailedLoginTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to improve security
|    As a user
|    I need to order some products
|
| Scenario:
|   Given: I have just selected an address
|   And: I am not logged in
|   When: I post to orders
|   Then: I should receive an error message
*/
namespace Tests\Feature\acceptance\http\order\route\create;


class CreateNewOrderFailedLoginTest extends AbstractFailedOrder
{
    use \SetUpAddressTrait;

    /**
     * @var integer
     */
    protected $code = 401;

    /**
     * @var string
     */
    protected $message = ['error' =>
        'You are not authorized to perform this request!'];


    protected function setUp()
    {
        parent::setUp();
        $this->setUpAddress();
        $this->setPostResponse([
            'address_id' => $this->addresses[0]->id
        ]);
    }
}
