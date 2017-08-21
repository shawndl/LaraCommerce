<?php

namespace App\Http\Controllers\User\API;


use App\Library\ShoppingCart\ShoppingCartAdd;
use App\Library\ShoppingCart\ShoppingCartInterface;
use App\Library\ShoppingCart\ShoppingCartRemove;
use App\Library\ShoppingCart\ShoppingCartUpdate;
use App\Library\Transformer\ShoppingCartTransformer;
use App\Product;
use App\Tax;
use Illuminate\Http\Request;
use Syscover\ShoppingCart\Facades\CartProvider;
use Syscover\ShoppingCart\Item;
use Syscover\ShoppingCart\TaxRule;

class ShoppingCartController extends AbstractUserAPIController
{
    /**
     * @var Product
     */
    protected $product;

    /**
     * @var ShoppingCartInterface
     */
    protected $shoppingCart;

    /**
     * ShoppingCartController constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * returns an array about the cart
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'cart' => ShoppingCartTransformer::transform()
        ], 200);
    }

    /**
     * adds an item to the shopping cart
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product' =>  'required|numeric',
            'quantity' =>  'required|numeric'
        ]);

        try {
            $product = $this->product->findOrFail($request->input('product'));
            $shoppingCart = new ShoppingCartAdd($product, CartProvider::instance());
            $shoppingCart->setQuantity($request->input('quantity'));
            $message = $shoppingCart->getResult();
        } catch (\Exception $exception) {
            return $this->hasError('Sorry there was an error adding to your cart.  Please try again', 422);
        }

        return response()->json([
            'cart' =>  ShoppingCartTransformer::transform(),
            'message' => $message
        ], 200);
    }

    /**
     * updates the quantity of a specific item
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'product' =>  'required|numeric',
            'quantity' => 'required|numeric'
        ]);

        try {
            $product = $this->product->findOrFail($request->input('product'));
            $shoppingCart = new ShoppingCartUpdate($product, CartProvider::instance());
            $shoppingCart->setQuantity($request->input('quantity'));
            $message = $shoppingCart->getResult();
        } catch (\Exception $exception) {
            return $this->hasError('Sorry there was an error updating your cart.  Please try again', 422);
        }

        return response()->json([
            'message' => $message,
            'cart' => ShoppingCartTransformer::transform()
        ], 200);
    }

    /**
     * removes an item from the cart
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'product' =>  'required|numeric',
        ]);

        try {
            $product = $this->product->findOrFail($request->input('product'));
            $shoppingCart = new ShoppingCartRemove($product, CartProvider::instance());
            $message = $shoppingCart->getResult();
        } catch (\Exception $exception) {
            return $this->hasError('Sorry there was an error removing an item from your cart.  Please try again', 422);
        }

        return response()->json([
            'message' => $message,
            'cart' => ShoppingCartTransformer::transform()
        ], 200);
    }
}
