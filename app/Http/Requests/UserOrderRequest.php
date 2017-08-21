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

    /**
     * create a new order
     *
     * @param Order $order
     * @param ApiResponseTracker $apiResponseTracker
     * @return void
     */
    public function createOrder(Order $order, ApiResponseTracker $apiResponseTracker)
    {
        //TODO: refactory this class it does not have a single responsibilty
        //TODO: create functions to track issues
        $this->apiResponse = $apiResponseTracker;
        $this->order = $order;
        $this->setAddress();
        $this->belongsToUser();
        if(!$this->apiResponse->hasError())
        {
            OrderDatabase::createOrder($this->order, $this->address, Auth::user());
        }
        $this->hasOrder();
        $this->onSuccess('Your order has been created!');
        $this->setOrderSession();
    }

    /**
     * updates an order if
     * @param ApiResponseTracker $apiResponseTracker
     * @return void
     */
    public function updateOrder(ApiResponseTracker $apiResponseTracker)
    {
        $this->apiResponse = $apiResponseTracker;
        $this->foundOrder();
        $this->orderBelongsToUser();
        $this->setAddress();
        if(!$this->apiResponse->hasError())
        {
            OrderDatabase::updateOrder($this->order, $this->address);
        }

        $this->onSuccess('Your order has been updated!');
        $this->setOrderSession();
    }

    /**
     * finds the order in the database based on a client provided order id
     *
     * @param $id
     * @return void
     */
    public function setOrder($id)
    {
        $this->order = Order::find($id);
    }

    /**
     * sets the address property to the picked address
     *
     * @return void
     */
    private function setAddress()
    {
        $this->address = Address::full($this->request->get('address_id'));
        if(!isset($this->address->id))
        {
            $this->apiResponse->setResult(
                422,
                'Error: The address you provided was not found in our system',
                true);
        }
    }

    /**
     * does the address belong to the user
     *
     * @return void
     */
    private function belongsToUser()
    {
        if(!$this->apiResponse->hasError() &&
            (int)$this->address->user_id !== Auth::user()->id)
        {
            $this->apiResponse->setResult(
                422,
                'Error: This address does not belong to the user logged in',
                true);
        }
    }

    /**
     * was an order created successfully if no an error message is set
     *
     * @return void
     */
    private function hasOrder()
    {
        if(!$this->apiResponse->hasError() && !isset($this->order->id))
        {
            $this->apiResponse->setResult(
                422,
                'Error: An order could not be created at this time.  Please try again later!',
                true);
        }
    }

    /**
     * does the order belong to the user
     *
     * @return void
     */
    private function orderBelongsToUser()
    {
        if(!$this->apiResponse->hasError()
            && isset($this->order) &&
            (int)$this->order->user_id !== (int)Auth::user()->id)
        {
            $this->apiResponse->setResult(
                422,
                'Error: The order does not belong to the user!',
                true);
        }
    }



    /**
     * if an order was not found then it will set the result to an error message
     *
     * @return void
     */
    private function foundOrder()
    {
        if(!isset($this->order->id))
        {
            $this->apiResponse->setResult(
                422,
                'Error: The order number provided does not match our system',
                true);
        }
    }

    /**
     * sets result on success
     *
     * @param string $message
     * @return void
     */
    private function onSuccess($message)
    {
        if(!$this->apiResponse->hasError())
        {
            $data = [
                'order_id'  => $this->order->id,
                'address'   => AddressTransformer::single($this->address),
                'user'      => UserTransformer::transform(Auth::user())
            ];
            $this->apiResponse->setResult(200, $message, false, $data);
        }
    }

    /**
     * creates a session for the order
     *
     * @return void
     */
    private function setOrderSession()
    {
        if(!$this->apiResponse->hasError())
        {
            $this->session()->put('user_order', $this->apiResponse->getResult()['data']);
        }
    }
}
