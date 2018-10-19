<?php

namespace App\Http\Controllers\User\API;


use App\Address;
use App\Http\Requests\UserOrderRequest;
use App\Library\API\ErrorTrackerBuilder\OrderErrorTrackerBuilder;
use App\Library\Order\OrderDatabase;
use App\Library\Transformer\AddressTransformer;
use App\Library\Transformer\OrderTransformers;
use App\Library\Transformer\UserTransformer;
use App\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends AbstractUserAPIController
{
    /**
     * @var Order
     */
    protected $order;

    /**
     * @var Address
     */
    protected $address;

    /**
     * @var JsonResponse
     */
    protected $response;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var OrderErrorTrackerBuilder
     */
    protected $errorBuilder;

    /**
     * OrderController constructor.
     * @param Order $order
     * @param Address $address
     * @param OrderErrorTrackerBuilder $orderErrorTrackerBuilder
     */
    function __construct(Order $order, Address $address, OrderErrorTrackerBuilder $orderErrorTrackerBuilder)
    {
        $this->errorBuilder = $orderErrorTrackerBuilder;
        $this->order = $order;
        $this->address = $address;
        $this->middleware('ajax.auth');
    }

    /**
     * returns a single order
     *
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Order $order)
    {
        if($order->belongsToUser(Auth::user()->id))
        {
            return response()->json([
                'status' => 'You order was found',
                'details' => OrderTransformers::single($order, true, true, true)
            ], 200);
        }
        return $this->hasError('Authorization Error', 403);
    }

    /**
     * creates a new order
     *
     * @param UserOrderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserOrderRequest $request)
    {
        $this->message = 'You have selected an address!';
        try {
            $this->address = $this->address->findOrFail($request->address_id);
            $apiErrorTracker = $this->errorBuilder->create(Auth::user(), $this->address);
            if(!$apiErrorTracker->hasError())
            {
                OrderDatabase::createOrder($this->order, $this->address, Auth::user());
            } else {
                return $this->hasError($apiErrorTracker->getResult()['status'],
                    $apiErrorTracker->getResult()['code']);
            }
            $this->setOrderSession();
        } catch (\Exception $exception) {
            return $this->processingError();
        }

        return response()->json($this->onSuccess(), 200);
    }

    /**
     * updates a users order
     *
     * @param UserOrderRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserOrderRequest $request, $id)
    {
        $this->message = 'You have updated your address!';
        try{
            $this->address = $this->address->findOrFail($request->address_id);
            $this->order = $this->order->findOrFail($id);
            $apiErrorTracker = $this->errorBuilder->update($this->order, Auth::user(), $this->address);
            if(!$apiErrorTracker->hasError())
            {
                OrderDatabase::updateOrder($this->order, $this->address);
            } else {
                return $this->hasError($apiErrorTracker->getResult()['status'],
                    $apiErrorTracker->getResult()['code']);
            }
            $this->setOrderSession();
        } catch (\Exception $exception) {
            return $this->processingError();
        }

        return response()->json($this->onSuccess(), 200);
    }

    /**
     * return to user on success
     *
     * @return array
     */
    protected function onSuccess()
    {
        return [
            'message' => $this->message,
            'order' => [
                'order_id'  => $this->order->id,
                'address'   => AddressTransformer::single($this->address),
                'user'      => UserTransformer::single(Auth::user())
            ]
        ];
    }

    /**
     * creates a session for the order
     *
     * @return void
     */
    private function setOrderSession()
    {
        session()->put('user_order', $this->onSuccess());
    }


}
