<?php

namespace App\Http\Controllers\User\API;


use App\Address;
use App\Http\Requests\UserAddressRequest;
use App\Library\API\ErrorTracker\AddressErrorTracker;
use App\Library\API\ErrorTracker\ErrorTrackerInterface;
use App\Library\Transformer\AddressTransformer;
use Illuminate\Support\Facades\Auth;

class AddressController extends AbstractUserAPIController
{
    /**
     * @var ErrorTrackerInterface
     */
    protected $addressErrorTracker;

    /**
     * Must be logged in to access this page
     * UserAddressController constructor.
     * @param AddressErrorTracker $addressErrorTracker
     */
    public function __construct(AddressErrorTracker $addressErrorTracker)
    {
        $this->addressErrorTracker = $addressErrorTracker;
        $this->middleware('ajax.auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserAddressRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserAddressRequest $request)
    {
        try{
            $request->createAddress(new Address());
        } catch (\Exception $exception) {
            return $this->hasError('Sorry there was an error creating your new address.  Please try again',
                422);
        }

        return $this->success('You have added an address!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserAddressRequest $request
     * @param Address $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserAddressRequest $request, Address $address)
    {
        $errors = $this->addressErrorTracker->update($address, Auth::user());
        if($errors->hasError())
        {
            return $this->hasError($errors->getResult()['status'], $errors->getResult()['code']);
        }

        try{
            $message = $request->updateAddress($address);
        } catch (\Exception $exception) {
            return $this->hasError('Sorry there was an error updating your new address.  Please try again',
                422);
        }
        return $this->success($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $address = Address::find($id);
        $errors = $this->addressErrorTracker->delete($address, Auth::user());
        if($errors->hasError())
        {
            return $this->hasError($errors->getResult()['status'], $errors->getResult()['code']);
        }

        try{
            $address->delete();
        } catch(\Exception $exception) {
            return $this->hasError('Sorry there was an error deleting your new address.  Please try again',
                422);
        }
        return $this->success('You deleted an address!');
    }

    /**
     * returns a success response
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    private function success($message)
    {
        return response()->json([
            'message' => $message,
            'addresses' => AddressTransformer::transform(Auth::user()->addresses)
        ], 200);
    }
}
