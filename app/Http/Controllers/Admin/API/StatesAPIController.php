<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Admin\AbstractAdminController;
use App\Http\Controllers\Traits\APIControllerTrait;
use App\Http\Requests\StatesFormRequest;
use App\State;
use Illuminate\Http\JsonResponse;

class StatesAPIController extends AbstractAdminController
{
    use APIControllerTrait;

    /**
     * @var State
     */
    protected $states;

    /**
     * StatesAPIController constructor.
     * @param State $states
     */
    public function __construct(State $states)
    {
        parent::__construct();
        $this->states = $states;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'states' => $this->states->paginate(10)
        ], 200);
    }

    /**
     * Store a newly created states in storage.
     *
     * @param  StatesFormRequest  $request
     * @return JsonResponse
     */
    public function store(StatesFormRequest $request)
    {
        try {
            $this->states->create($request->only(['name', 'abbreviation']));
        } catch (\Exception $exception) {
            return $this->processingError();
        }

        return $this->jsonMessage('You have created a new state!');
    }

    /**
     * Update the specified state in storage.
     *
     * @param  StatesFormRequest  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(StatesFormRequest $request, $id)
    {
        try {
            $this->states->find($id)->update($request->only(['name', 'abbreviation']));
        } catch (\Exception $exception) {
            return $this->processingError();
        }

        return $this->jsonMessage('You have updated a state!');
    }

    /**
     * Remove the specified state from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->states->findOrFail($id)->delete();
        } catch (\Exception $exception) {
            return $this->processingError();
        }
        return $this->jsonMessage('You deleted a state!');
    }
}
