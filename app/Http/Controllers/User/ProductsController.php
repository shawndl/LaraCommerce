<?php

namespace App\Http\Controllers\User;

use App\Category;
use App\Library\Format\DateFormat;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($title, Product $product)
    {
        $query =  $product->where('title', $title)->with(['reviews' => function($query){
            $query->latest()->limit(4);
        } ])->first();

        return view('ecommerce.show', [
            'product' => $query
        ]);
    }
}
