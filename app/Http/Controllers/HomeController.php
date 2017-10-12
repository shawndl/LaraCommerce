<?php

namespace App\Http\Controllers;

use App\Library\Transformer\ProductsTransformer;
use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var Product
     */
    protected $products;

    /**
     * HomeController constructor.
     * @param Product $products
     */
    function __construct(Product $products)
    {
        $this->products = $products;
    }

    /**
     * Displays a list of products to the user
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $products = $this->products->with(['sales' => function($query){
                return $query->current();
            }])->paginate(9);
        } catch (\Exception $exception) {
            $exception->getMessage();
        }

        return view('ecommerce.welcome', [
            'products' => $products
        ]);
    }

    /**
     * shows the about page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        return view('ecommerce.about');
    }

    /**
     * shows teh contact page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact()
    {
        return view('ecommerce.contact');
    }
}
