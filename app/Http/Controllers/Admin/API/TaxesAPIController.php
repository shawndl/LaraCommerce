<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Admin\AbstractAdminController;
use App\Http\Controllers\Traits\APIControllerTrait;
use App\Http\Requests\TaxFormRequest;
use App\Tax;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class TaxesAPIController extends AbstractAdminController
{
    use APIControllerTrait;

    /**
     * @var Tax
     */
    protected $taxes;

    /**
     * TaxesAPIController constructor.
     * @param Tax $taxes
     */
    public function __construct(Tax $taxes)
    {
        parent::__construct();
        $this->taxes = $taxes;
    }

    /**
     * gets paiginated taxes and returns the json
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'taxes' => $this->taxes->paginate(10)
        ], 200);
    }

    /**
     * gets all taxes and returns the json
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        return response()->json([
            'taxes' => $this->taxes->all()
        ], 200);
    }

    /**
     * Redirects to the tax page
     *
     * @return Redirect
     */
    public function create()
    {
        return redirect()->action('Admin\TaxesController@index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TaxFormRequest  $request
     * @return JsonResponse
     */
    public function store(TaxFormRequest $request)
    {
        try {
            $this->taxes->create([
                'name' => $request->name,
                'percent' => $request->percent,
                'description' => $request->description
            ]);
        } catch (\Exception $exception) {
            $this->processingError();
        }
        return $this->jsonMessage('You have created a new tax!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Redirects to the tax page
     *
     * @param  int  $id
     * @return Redirect
     */
    public function edit($id)
    {
        return redirect()->action('Admin\TaxesController@index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TaxFormRequest  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(TaxFormRequest $request, $id)
    {
        try {
            $this->taxes = $this->taxes->find($id);
            $this->taxes->update($request->all());
        } catch (\Exception $exception) {
            return $this->processingError();
        }

        return $this->jsonMessage('You updated a tax!');
    }

    /**
     * Remove a tax from the database
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->taxes = $this->taxes->findOrFail($id);
            $this->taxes->delete();
        } catch (\Exception $exception) {
            $this->processingError();
        }
        return $this->jsonMessage('You deleted a tax!');
    }
}
