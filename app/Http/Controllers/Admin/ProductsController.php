<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\APIControllerTrait;
use App\Http\Requests\ProductFormRequest;
use App\Image as Img;
use App\Library\Database\Processors\ProductDBProcessor;
use App\Library\Transformer\ProductsTransformer;
use App\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redirect;


class ProductsController extends AbstractAdminController
{
    use APIControllerTrait;

    /**
     * @var Product
     */
    protected $products;

    /**
     * @var Img
     */
    protected $image;

    /**
     * @var ProductDBProcessor
     */
    protected $processor;

    /**
     * ProductsController constructor.
     * @param Product $products
     * @param Img $image
     * @param ProductDBProcessor $processor
     */
    public function __construct(Product $products, Img $image, ProductDBProcessor $processor)
    {
        parent::__construct();
        $this->products = $products;
        $this->image = $image;
        $this->processor = $processor;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index', [
            'table' => 'admin._includes._tables._products'
        ]);
    }

    /**
     * Redirects to the products page
     *
     * @return Redirect
     */
    public function create()
    {
        return redirect()->action('Admin\ProductsController@index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductFormRequest $request
     * @return JsonResponse
     */
    public function store(ProductFormRequest $request)
    {
        try {
            $this->processor->create($this->products, $this->image, $request);
        } catch (\Exception $exception) {
            return $this->processingError();
        }

        return response()->json([
            'message' => 'You have created a new product!'
        ], 200);
    }

    /**
     * Returns a json response with details of a single product
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $this->products = $this->products->findOrFail($id);
        } catch (\Exception $exception) {
            return $this->processingError();
        }
        return response()->json([
            'product' => ProductsTransformer::single($this->products)
        ]);
    }

    /**
     * Redirects to the products page
     *
     * @param  int  $id
     * @return Redirect
     */
    public function edit($id)
    {
        return redirect()->action('Admin\ProductsController@index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductFormRequest  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(ProductFormRequest $request, $id)
    {
        $this->products = $this->products->findOrFail($id);
        $this->image = $this->products->image;
        $this->processor->update($this->products, $this->image, $request);
        try {

        } catch (\Exception $exception) {
            return $this->processingError();
        }

        return response()->json([
            'message' => 'You have updated the product!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->products = $this->products->findOrFail($id);
        $message = "You deleted the {$this->products->title} product!";

        $this->products->findOrFail($id)->delete();

        return response()->json([
            'message' => $message
        ], 200);
    }
}
