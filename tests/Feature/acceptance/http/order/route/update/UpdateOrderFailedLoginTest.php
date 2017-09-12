<?php
/*
|--------------------------------------------------------------------------
| UpdateOrderFailedLoginTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature: 
|    In order to improve security
|    As a user
|    I need to update my order
|
| Scenario:
|   Given: I have just selected a new address for my order
|   And: I am not logged in
|   When: I post to orders
|   Then: I should receive an error message
*/
namespace Tests\Feature\acceptance\http\order\route\update;


class UpdateOrderFailedLoginTest extends AbstractFailedUpdateOrder
{
    use \SetUpOrderTrait;

    /**
     * @var integer
     */
    protected $code = 401;

    /**
     * @var string
     */
    protected $message = ['error' => 'You are not authorized to perform this request!'];

    protected function setUp()
    {
        parent::setUp();
        $this->setUpAddress();
        $this->setUpOrderDatabase(true);
        $this->postRoute = 'order/' . $this->orders[0]->id;
        $this->setPostResponse([
            '_method' => 'PATCH',
            'address_id' => $this->addresses[1]->id
        ]);
    }
}
