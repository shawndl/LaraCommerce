<?php

namespace App\Http\Controllers\User\API;


use App\Http\Requests\UserOrderRequest;
use App\Library\API\ApiResponseTracker;
use App\Library\Transformer\OrderTransformers;
use App\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends AbstractUserAPIController
{
    /**
     * OrderController constructor.
     */
    function __construct()
    {
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
    }

    /**
     * creates a new order
     *
     * @param UserOrderRequest $request
     * @param ApiResponseTracker $responseTracker
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserOrderRequest $request, ApiResponseTracker $responseTracker)
    {
        $request->createOrder(new Order(), $responseTracker);
        return $this->getResponse($responseTracker->getResult(), 'order');
    }

    /**
     * updates a users order
     *
     * @param UserOrderRequest $request
     * @param ApiResponseTracker $responseTracker
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserOrderRequest $request, ApiResponseTracker $responseTracker, $id)
    {
        $request->setOrder((int)$id);
        $request->updateOrder($responseTracker);
        return $this->getResponse($responseTracker->getResult(), 'order');
    }


}
