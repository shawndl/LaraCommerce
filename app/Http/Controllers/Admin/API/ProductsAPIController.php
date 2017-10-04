<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Admin\AbstractAdminController;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsAPIController extends AbstractAdminController
{
    /**
     * @var Product
     */
    protected $products;

    /**
     * ProductController constructor.
     * @param Product $products
     */
    public function __construct(Product $products)
    {
        parent::__construct();
        $this->products = $products;
    }

    /**
     * gets a paginated products array
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $paginate = $this->products
            ->with('category')
            ->with('image')
            ->with(['sales' => function($query){
                return $query->current();
            }])
            ->paginate(10);

        return response()->json([
            'products' => $paginate
        ], 200);
    }
}
