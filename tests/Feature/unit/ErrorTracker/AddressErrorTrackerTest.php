<?php

namespace Tests\Feature\unit\ErrorTracker;


use App\Library\API\ApiResponseTracker;
use App\Library\API\ErrorTracker\AddressErrorTracker;

class AddressErrorTrackerTest extends AbstractTestsErrorTracker
{
    /**
     * @var AddressErrorTracker
     */
    protected $errorTracker;

    /**
     * @test
     * @group error_tracking
     * @group unit
     */
    public function it_must_be_able_to_add_an_error_when_the_address_was_not_found()
    {
        $this->setUpEnvironment(false);
        $this->apiTracker = $this->errorTracker->update($this->address, $this->user);
        $this->assertTrue($this->apiTracker->hasError());
        $this->assertEquals('Error: there is no address in your account that matches the one you provided!',
            $this->apiTracker->getResult()['status']);
        $this->assertEquals(422,    $this->apiTracker->getResult()['code']);

    }

    /**
     * @test
     * @group error_tracking
     * @group unit
     */
    public function it_must_return_an_error_if_address_does_not_belong_to_the_user()
    {
        $this->setUpEnvironment(true, 1, 2);
        $this->apiTracker = $this->errorTracker->update($this->address, $this->user);
        $this->assertTrue($this->apiTracker->hasError());
        $this->assertEquals('Error: You are not authorized to perform this action',
            $this->apiTracker->getResult()['status']);
        $this->assertEquals(403,    $this->apiTracker->getResult()['code']);
    }

    /**
     * @test
     * @group error_tracking
     * @group unit
     */
    public function it_must_not_return_an_error_if_none_are_found()
    {
        $this->setUpEnvironment(true, 1, 1);
        $this->apiTracker = $this->errorTracker->update($this->address, $this->user);
        $this->assertFalse($this->apiTracker->hasError());
    }


    private function setUpEnvironment($addressIsset = true, $userID = 1, $addressUserID = 1)
    {
        $this->mockAddress($addressIsset, $addressUserID);
        $this->mockUser($userID);
        $this->errorTracker = new AddressErrorTracker(new ApiResponseTracker());
    }
}
