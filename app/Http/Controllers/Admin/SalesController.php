<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AbstractAPIController;
use App\Http\Requests\SalesFormRequest;
use App\Library\Format\SalesDateFormat;
use App\Library\Transformer\SalesTransformer;
use App\Product;
use App\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SalesController extends AbstractAdminController
{
    /**
     * @var Sale
     */
    protected $sale;

    /**
     * @var Product
     */
    protected $product;

    /**
     * SalesController constructor.
     * @param Sale $sale
     * @param Product $product
     */
    public function __construct(Sale $sale, Product $product)
    {
        parent::__construct();
        $this->sale = $sale;
        $this->product = $product;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Redirects the user back to admin products page
     *
     * @return Redirect
     */
    public function create()
    {
        return redirect()->action('AdminProductsController@index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SalesFormRequest $request
     * @return JsonResponse
     */
    public function store(SalesFormRequest $request)
    {
        try {
            $this->product = $this->product->findOrFail($request->product_id);
            $this->sale->create([
                'product_id' => $request->product_id,
                'start' => SalesDateFormat::format(new \DateTime($request->start)),
                'finish' => SalesDateFormat::format(new \DateTime($request->finish)),
                'discount' => $request->discount
            ]);
        } catch (\Exception $exception) {
            return $this->processingError();
        }

        return response()->json([
            'message' => "You have added a sale to the {$this->product->title} product!"
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->sale = $this->sale->findOrFail($id);

        return response()->json([
            'sale' => SalesTransformer::single($this->sale)
        ], 200);
    }

    /**
     * Redirects to the products page
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->action('AdminProductsController@index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $this->product = $this->product->findOrFail($request->product_id);
            $this->sale = $this->sale->findOrFail($id);
            $this->sale->update([
                'product_id' => $request->product_id,
                'start' => SalesDateFormat::format(new \DateTime($request->start)),
                'finish' => SalesDateFormat::format(new \DateTime($request->finish)),
                'discount' => $request->discount
            ]);
        } catch (\Exception $exception) {
            return $this->processingError();
        }

        return response()->json([
            'message' => 'You updated a sale!'
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
        //
    }
}
