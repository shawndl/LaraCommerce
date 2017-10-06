<?php

namespace App\Http\Controllers\User\API;


use App\Library\Transformer\UserTransformer;
use Illuminate\Support\Facades\Auth;

class UserController extends AbstractUserAPIController
{
    /**
     * OrderController constructor.
     */
    function __construct()
    {
        $this->middleware('ajax.auth');
    }

    /**
     * returns the users information if logged in
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $user = UserTransformer::single(Auth::user());
        } catch (\Exception $exception) {
            return $this->processingError();
        }
        return response()->json([
            'user' => $user
        ], 200);
    }
}
