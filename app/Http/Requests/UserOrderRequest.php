<?php

namespace App\Http\Requests;

use App\Address;
use App\Library\API\ApiResponseTracker;
use App\Library\Order\OrderDatabase;
use App\Library\Transformer\AddressTransformer;
use App\Library\Transformer\UserTransformer;
use App\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class UserOrderRequest extends FormRequest
{
    /**
     * @var ApiResponseTracker
     */
    protected $apiResponse;

    /**
     * @var Address
     */
    protected $address;

    /**
     * @var Order
     */
    protected $order;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address_id' => "required|numeric",
        ];
    }
}
