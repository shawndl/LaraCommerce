<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'total', 'sub_total', 'address_id', 'taxes', 'ship_date', 'order_date', 'shipped'
    ];

    /**
     * formats the total into cents
     *
     * @return integer
     */
    public function formatTotalCents()
    {
        return number_format($this->total * 100, 0, '', '');
    }

    /**
     * gets a formatted string of the user order date
     *
     * @return string
     */
    public function formatOrderDate()
    {
        $date = \DateTime::createFromFormat('Y-m-d', $this->order_date);
        return $date->format('jS M, Y');
    }

    /**
     * gets a formatted string of the user ship date
     *
     * @return string | boolean
     */
    public function formatShipDate()
    {
        if(is_null($this->ship_date))
        {
            return false;
        }
        $date = \DateTime::createFromFormat('Y-m-d', $this->ship_date);
        return $date->format('jS M, Y');
    }

    /**
     * An order can have many products
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany('App\Product')->withPivot('order_id', 'product_id', 'quantity');
    }

    /**
     * an order has a single user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * an order has an address
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo('App\Address');
    }

    /**
     * does the order belong to the user
     *
     * @return bool
     */
    public function belongsToUser($userID)
    {
       return ((int)$this->user_id === (int)$userID);
    }

    /**
     * does the order exist
     *
     * @param $id
     * @return bool
     */
    public function exists($id)
    {
        return (is_null($this->find((int)$id))) ? false : true;
    }
}
