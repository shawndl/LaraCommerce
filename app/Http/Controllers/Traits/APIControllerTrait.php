<?php
/*
|--------------------------------------------------------------------------
| APIControllerTrait.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for providing common functions for controllers
| that use API requests
*/

namespace App\Http\Controllers\Traits;


trait APIControllerTrait
{
    /**
     * returns an error message
     *
     * @param $error
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function hasError($error, $code)
    {
        return response()->json([
            'error' => $error
        ], $code);
    }

    /**
     * returns a standard processing error
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function processingError()
    {
        return $this->hasError('Sorry there was an error processing your.  Please try again',
            422);
    }

    /**
     * returns a standard json message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonMessage($message)
    {
        return response()->json([
            'message' => $message
        ], 200);
    }
}