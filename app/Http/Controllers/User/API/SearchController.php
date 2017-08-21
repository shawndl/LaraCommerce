<?php

namespace App\Http\Controllers\User\API;

use App\Library\Transformer\ProductsTransformer;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * returns the users search results
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request, Product $product)
    {
        $this->validate($request, [
           'search' => 'required|basic_characters'
        ]);
        $products = $product->search($request->search)->get();

        return response()->json([
            'products' => ProductsTransformer::transform($products),
            'search' => $request->search],
            200);
    }
}
