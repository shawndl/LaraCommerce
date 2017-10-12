<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\AbstractAPIController;
use App\Http\Controllers\Admin\AbstractAdminController;
use App\Http\Controllers\Traits\APIControllerTrait;
use App\Http\Requests\ShipOrderRequest;
use App\Library\Transformer\OrderTransformers;
use App\Order;
use App\Http\Controllers\Controller;

class OrdersAPIController extends AbstractAdminController
{
    use APIControllerTrait;
    /**
     * returns a single order
     *
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Order $order)
    {
        return response()->json([
            'details' => OrderTransformers::single($order, true, true, true)
        ], 200);
    }

    /**
     * updates the shipping order
     *
     * @param ShipOrderRequest $request
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ShipOrderRequest $request, Order $order)
    {
        try {
            $order->update([
                'ship_date' => $request->ship,
                'shipped' => 1
            ]);
        } catch (\Exception $exception) {
            $this->processingError();
        }

        return response()->json([
            'message' => 'The order has been shipped'
        ], 200);
    }
}
