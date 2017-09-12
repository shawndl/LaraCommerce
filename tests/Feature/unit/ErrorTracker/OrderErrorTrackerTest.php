<?php

namespace Tests\Feature\unit\ErrorTracker;

use App\Library\API\ApiResponseTracker;
use App\Library\API\ErrorTracker\OrderErrorTracker;

class OrderErrorTrackerTest extends AbstractTestsErrorTracker
{
    /**
     * @var OrderErrorTracker
     */
    protected $orderErrorTracker;

    /**
     * @test
     * @group error_tracking
     * @group unit
     */
    public function it_must_return_an_error_if_the_address_does_not_belong_to_the_user()
    {
        $this->mockProperties(true, 1, false, 2);
        $this->apiTracker = $this->orderErrorTracker->create($this->order);
        $this->assertEquals(422, $this->apiTracker->getResult()['code']);
        $this->assertEquals('Error: we are unable to process your request',
            $this->apiTracker->getResult()['status']);
    }

    /**
     * @test
     * @group error_tracking
     * @group unit
     */
    public function it_must_return_an_error_if_the_order_does_not_belong_to_the_user()
    {
        $this->mockProperties(false, 1, false, 1, 2);
        $this->apiTracker = $this->orderErrorTracker->update($this->order, $this->user);
        $this->assertEquals(403, $this->apiTracker->getResult()['code']);
        $this->assertEquals('Error: we are unable to process your request',
            $this->apiTracker->getResult()['status']);
    }

    /**
     * @test
     * @group error_tracking
     * @group unit
     */
    public function it_must_return_an_error_if_the_address_does_not_belong_to_the_user_on_update()
    {
        $this->mockProperties(true, 1, false, 2);
        $this->apiTracker = $this->orderErrorTracker->update($this->order, $this->user);
        $this->assertEquals(403, $this->apiTracker->getResult()['code']);
        $this->assertEquals('Error: we are unable to process your request',
            $this->apiTracker->getResult()['status']);
    }

    /**
     * creates a new order
     */
    private function createNewOrder()
    {
        $this->orderErrorTracker = new OrderErrorTracker(new ApiResponseTracker());
    }

    /**
     * creates the mocked objects
     *
     * @param $hasResultReturn
     * @param $addressUser
     * @param $addressHasResult
     * @param $userId
     * @return void
     */
    private function mockProperties($hasResultReturn, $addressUser, $addressHasResult, $userId, $orderUserID = null)
    {
        $this->createNewOrder();
        $this->mockOrder($orderUserID);
        $this->mockAddress($hasResultReturn, $addressUser, $addressHasResult);
        $this->mockUser($userId);
        $this->addProperties();

    }

    /**
     * sets the properties needed for an order error tracker
     *
     * @param bool $addUser
     * @return void
     */
    private function addProperties($addUser = true)
    {
        $this->orderErrorTracker->address = $this->address;
        if($addUser)
        {
            $this->orderErrorTracker->user = $this->user;
        }
    }
}
