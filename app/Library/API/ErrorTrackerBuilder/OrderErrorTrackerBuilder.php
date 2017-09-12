<?php
/*
|--------------------------------------------------------------------------
| OrderErrorTrackerBuilder.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for building a building a error tracker object
*/

namespace App\Library\API\ErrorTrackerBuilder;


use App\Address;
use App\Library\API\ApiResponseTracker;
use App\Library\API\ErrorTracker\OrderErrorTracker;
use App\Order;
use App\User;

class OrderErrorTrackerBuilder
{
    /**
     * @var Order
     */
    protected $order;

    /**
     * @var ApiResponseTracker
     */
    protected $apiTracker;

    /**
     * @var OrderErrorTracker
     */
    protected $orderTracker;

    /**
     * OrderErrorTrackerBuilder constructor.
     * @param Order $order
     * @param ApiResponseTracker $apiTracker
     * @param OrderErrorTracker $orderErrorTracker
     */
    public function __construct(Order $order, ApiResponseTracker $apiTracker, OrderErrorTracker $orderErrorTracker)
    {
        $this->order = $order;
        $this->apiTracker = $apiTracker;
        $this->orderTracker = $orderErrorTracker;
    }

    /**
     * Builds an error tracker on create
     *
     * @param User $user
     * @param Address $address
     * @return ApiResponseTracker
     */
    public function create(User $user, Address $address)
    {
        $this->orderTracker->address = $address;
        $this->orderTracker->user = $user;
        return $this->orderTracker->create($this->order);
    }

    /**
     * Builds an error tracker on update
     * @param User $user
     * @param Order $order
     * @param Address $address
     * @return ApiResponseTracker
     */
    public function update(Order $order, User $user, Address $address)
    {
        $this->orderTracker->address = $address;
        return $this->orderTracker->update($order, $user);
    }






}