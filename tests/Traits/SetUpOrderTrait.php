<?php

/*
|--------------------------------------------------------------------------
| SetUpOrderTrait.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for creating an environement
*/
use App\Category;
use App\Order;
use App\Product;
use App\State;
use App\Tax;
use App\User;
use App\Address;

trait SetUpOrderTrait
{
    use SetUpAddressTrait, SetUpProductsTrait;

    protected $orderDetails = [
        [
            'total' => 18.45,
            'sub_total' => 16.45,
            'taxes' => 2.00,
            'order_date' => '2017-06-01',
            'ship_date' => '2017-06-05'
        ],
        [
            'total' => 9.99,
            'sub_total' => 2.10,
            'taxes' => 7.89,
            'order_date' => '2017-06-05',
            'ship_date' => null
        ],
    ];

    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $orders;

    /**
     * sets up the records needed for a basic order
     *
     * @return void
     */
    public function setUpOrderDatabase($single = false)
    {
        $this->setUpAddress();
        foreach ($this->orderDetails as $orderDetail)
        {
            $order = new Order();
            $order->user_id = $this->user->id;
            $order->address_id = $this->addresses[0]->id;
            $order->total = $orderDetail['total'];
            $order->sub_total = $orderDetail['sub_total'];
            $order->taxes = $orderDetail['taxes'];
            $order->order_date = $orderDetail['order_date'];
            $order->ship_date = $orderDetail['ship_date'];
            $order->save();
            if($single)
            {
                break;
            }
        }
        $this->orders = Order::all();
    }

    /**
     * adds products to the order
     *
     * @param int $order
     * @return void
     */
    public function addProductsToOrder($order = 0)
    {
        $this->setUpProduct();
        foreach ($this->products as $product)
        {
            $this->orders[$order]->products()->attach($product->id, ['quantity' => 1]);
        }
    }

    /**
     * changes the user
     *
     * @param User $user
     * @return void
     */
    public function changeOrdersUser(User $user)
    {
        $this->orders[0]->user_id = $user->id;
        $this->orders[0]->save();
    }
}