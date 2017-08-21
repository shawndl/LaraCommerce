<?php

namespace Tests\Feature\unit\ErrorTracker;

use App\Address;
use App\Library\API\ApiResponseTracker;
use App\Library\API\ErrorTracker\AddressErrorTracker;
use App\User;
use Tests\TestCase;

class AddressErrorTrackerTest extends TestCase
{
    protected $address;

    protected $user;

    /**
     * @var ApiResponseTracker
     */
    protected $apiTracker;

    /**
     * @var AddressErrorTracker
     */
    protected $errorTracker;

    /**
     * @test
     * @group errortracking
     */
    public function it_must_be_able_to_add_an_error_when_the_address_was_not_found()
    {
        $this->setUpEnvironment();
        $this->apiTracker = $this->errorTracker->update($this->address, $this->user);
        $this->assertTrue($this->apiTracker->hasError());
        $this->assertEquals('Error: there is no address in your account that matches the one you provided!',
            $this->apiTracker->getResult()['status']);
        $this->assertEquals(422,    $this->apiTracker->getResult()['code']);

    }

    /**
     * @test
     * @group errortracking
     */
    public function it_must_return_an_error_if_address_does_not_belong_to_the_user()
    {
        $this->setUpEnvironment(false, 1, 2);
        $this->apiTracker = $this->errorTracker->update($this->address, $this->user);
        $this->assertTrue($this->apiTracker->hasError());
        $this->assertEquals('Error: You are not authorized to perform this action',
            $this->apiTracker->getResult()['status']);
        $this->assertEquals(401,    $this->apiTracker->getResult()['code']);
    }

    /**
     * @test
     * @group errortracking
     */
    public function it_must_not_return_an_error_if_none_are_found()
    {
        $this->setUpEnvironment(false, 1, 1);
        $this->apiTracker = $this->errorTracker->update($this->address, $this->user);
        $this->assertFalse($this->apiTracker->hasError());
    }

    /**
     * @param $addressIsset
     * @param $userID
     * @param $addressUserID
     */
    private function setUpEnvironment($addressIsset = true, $userID = 1, $addressUserID = 1)
    {
        $this->mockAddress($addressIsset, $addressUserID);
        $this->mockUser($userID);
        $this->errorTracker = new AddressErrorTracker(new ApiResponseTracker());
    }

    /**
     * mocks the address model and returns the address id and the user id
     *
     * @param boolean $return
     * @param int $user
     * @return void
     */
    private function mockAddress($return = true, $user = 1)
    {
        $this->address = \Mockery::mock(Address::class);
        $this->address->shouldReceive('isEmpty')
            ->once()
            ->andReturn($return);

        $this->address->shouldReceive('getAttribute')
            ->once()
            ->with('user_id')
            ->andReturn($user);
    }

    /**
     * mocks a user model and sets the return for the id
     *
     * @param $return
     * @return void
     */
    private function mockUser($return)
    {
        $this->user = \Mockery::mock(User::class);
        $this->user->shouldReceive('getAttribute')
            ->once()
            ->with('id')
            ->andReturn($return);
    }
}
