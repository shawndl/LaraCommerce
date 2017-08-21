<?php

namespace App\Http\Controllers;

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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ecommerce.welcome', [
            'products' => $this->products->paginate(9)
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
