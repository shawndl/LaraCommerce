<?php

namespace App\Http\Requests;

use App\Library\Order\OrderDatabase;
use App\Library\Transformer\OrderTransformers;
use App\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use Syscover\ShoppingCart\Facades\CartProvider;

class BillingFormRequest extends FormRequest
{
    /**
     * order the customer created
     *
     * @var Order
     */
    private $order;

    /**
     * stripe customer
     *
     * @var Customer
     */
    private $customer;

    /**
     * stripe charge object
     *
     * @var Charge
     */
    private $charge;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'stripeEmail' => 'required|email',
            'stripeToken' => 'required',
            'order_id'    => 'required|numeric'
        ];
    }

    /**
     * charges the card
     *
     * @return array
     */
    public function save()
    {
        $this->order = Order::findOrFail($this->order_id);
        OrderDatabase::addPricing($this->order, CartProvider::instance());
        Stripe::setApiKey(config('services.stripe.secret'));
        $this->setCustomer();
        $this->setCharge();
    }

    /**
     * update that the user paid
     *
     * @return void
     */
    public function updateUserPaid()
    {
        OrderDatabase::addProducts($this->order, CartProvider::instance());
        if(isset($this->order))
        {
            $this->order->paid_for = 1;
            $this->order->save();
        }
    }

    /**
     * gets an array of order information that will be used by the json request
     *
     * @return array
     */
    public function getOrder()
    {
        if(isset($this->order))
        {
            return OrderTransformers::single($this->order, true, true);
        }
    }

    /**
     * sets the stripe customer property
     *
     * @return void
     */
    private function setCustomer()
    {
        $this->customer = Customer::create([
            'email' => $this->request->get('stripeEmail'),
            'source' => $this->request->get('stripeToken'),
        ]);
    }

    /**
     * set charge object
     *
     * @return void
     */
    private function setCharge()
    {
        $this->charge = Charge::create([
            'customer' => $this->customer->id,
            'amount'    => $this->order->formatTotalCents(),
            'currency' => 'usd'
        ]);
    }
}
