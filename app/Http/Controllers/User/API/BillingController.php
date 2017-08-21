<?php

namespace App\Http\Controllers\User\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BillingFormRequest;
use App\Library\Order\ShippingDateEstimator;
use Syscover\ShoppingCart\Facades\CartProvider;

class BillingController extends Controller
{
    /**
     * OrderController constructor.
     */
    function __construct()
    {
        $this->middleware('ajax.auth');
    }


    /**
     * Processes a user payment and returns the response
     *
     * @param BillingFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BillingFormRequest $request)
    {
        try {
            $request->save();
            $request->updateUserPaid();

        } catch (\Exception $e) {
            return response()->json([
                'status' => $e->getMessage()
            ], 422);
        }
        CartProvider::instance()->destroy();
        session()->forget('user_order');

        return response()->json([
            'status' => 'Your payment was accepted!',
            'estimated_arrival_date' => ShippingDateEstimator::arrivalDate(new \DateTime()),
            'data' => $request->getOrder()
        ], 200);
    }
}
