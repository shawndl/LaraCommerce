<?php
/*
|--------------------------------------------------------------------------
| OrderTransformers.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for receiving either an order or a collection
| and returning an array of information about a single order or a collection
| of orders
| 1) orders's pricing details [total, taxes, subTotal]
| 2) orders address [address, city, state, postal_code]
| 3) Each products details [Product name, product price
| 4) User details [first_name, last_name, email]
*/

namespace App\Library\Transformer;


use App\Library\Order\ShippingDateEstimator;
use App\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderTransformers
{
    /**
     * @var Order
     */
    private static $order;

    /**
     * gets the information for a single order
     *
     * @param Collection $collection
     * @param bool $address
     * @param bool $user
     * @param bool $products
     * @return array
     */
    public static function transform(Collection $collection, $address = false, $user = false, $products = false)
    {
        $orderArray = [];
        foreach ($collection as $item)
        {
            $orderArray[] = self::single($item, $user, $address, $products);
        }
        return $orderArray;
    }

    /**
     * get information about a single address
     *
     * @param Order $order
     * @param bool $user
     * @param bool $address
     * @param bool $products
     * @return array
     */
    public static function single(Order $order, $user = false, $address = false, $products = false)
    {
        self::$order = $order;
        $orderArray['order'] = self::getOrderBasics();
        $orderArray['order']['cost'] = self::getOrderCosts();

        // Should the array include information about the user
        if($user)
        {
            $orderArray['order']['user'] = self::getUser();
        }
        // Should the array include information about the address
        if($address)
        {
            $orderArray['order']['address'] = self::getAddress();
        }

        // Should the array include information about the products
        if($products)
        {
            $orderArray['order']['products'] = self::getProducts();
        }
        return $orderArray;
    }

    /**
     * returns the basic information about an order
     *
     * @return array
     */
    private static function getOrderBasics()
    {
        return [
            'id' => self::$order->id,
            'created' => true,
            'paid_for' => (self::$order->paid_for) ? true : false,
            'arrival' => ShippingDateEstimator::arrivalDate(new \DateTime()),
            'order_date' => self::$order->formatOrderDate(),
            'ship_date' => self::$order->formatShipDate(),
            'shipped' => (self::$order->shipped) ? true : false
        ];
    }

    /**
     * gets the details of the order
     *
     * @return array
     */
    private static function getOrderCosts()
    {
        return [
            'total'     => self::$order->total,
            'sub_total' => self::$order->sub_total,
            'taxes'     => self::$order->taxes
        ];
    }

    /**
     * gets the details from the products
     *
     * @return array
     */
    private static function getProducts()
    {
        return array_map(function($product){
            return [
                'id'            => $product['id'],
                'total'         => $product['price'],
                'title'         => $product['title'],
                'description'   => $product['description'],
                'image'         => $product['image']['path'],
                'quantity'      => $product['pivot']['quantity']
            ];
        }, self::$order->products()->with('image')->get()->toArray());
    }

    /**
     * gets the users details
     *
     * @return array
     */
    private static function getUser()
    {
        $user = self::$order->user;
        return [
            'user_name'     => $user->username,
            'email'         => $user->email,
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name
        ];
    }

    /**
     * gets address details
     *
     * @return array
     */
    private static function getAddress()
    {
        $address = self::$order->address()->with('state')->first();
        return [
            'street_address' => $address->address,
            'city'           => $address->city,
            'state'          => $address->state->name,
            'postal_code'    => $address->postal_code
        ];
    }
}