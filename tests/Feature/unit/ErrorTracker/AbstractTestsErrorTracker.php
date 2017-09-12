<?php

namespace Tests\Feature\unit\ErrorTracker;

use App\Address;
use App\Library\API\ApiResponseTracker;
use App\Order;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AbstractTestsErrorTracker extends TestCase
{
    protected $address;

    protected $user;

    protected $order;

    /**
     * @var ApiResponseTracker
     */
    protected $apiTracker;

    /**
     * mocks the address model and returns the address id and the user id
     *
     * @param boolean $return
     * @param int $user
     * @param bool $hasResult
     * @return void
     */
    protected function mockAddress($return = true, $user = 1, $hasResult = true)
    {
        $this->address = \Mockery::mock(Address::class);
        if($hasResult)
        {
            $this->address->shouldReceive('hasResult')
                ->once()
                ->andReturn($return);
        }

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
    protected function mockUser($return)
    {
        $this->user = \Mockery::mock(User::class);
        $this->user->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn($return);
    }

    /**
     * mocks the user object
     *
     * @param null $return
     */
    protected function mockOrder($return = null)
    {
        $this->order = \Mockery::mock(Order::class);
        $this->order->shouldReceive('getAttribute')
            ->with('user_id')
            ->andReturn($return);
    }
}
