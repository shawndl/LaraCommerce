<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends AbstractAdminController
{
    /**
     * @var Order
     */
    protected $order;

    /**
     * OrderController constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        parent::__construct();
        $this->order = $order;
    }


    /**
     * Display all the orders details
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.index', [
            'table' => 'admin._includes._tables._orders',
            'orders' => $this->order->paginate(10)
        ]);
    }

    /**
     * Display a single order
     *r
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        return view('admin.show', [
            'show' => 'admin._includes._show._order',
            'id' => (int)$id
        ]);
    }
}
