<?php
/*
|--------------------------------------------------------------------------
| AbstractErrorTracker.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for keeping tack of errors
*/

namespace App\Library\API\ErrorTracker;


use App\Library\API\ApiResponseTracker;
use App\User;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractErrorTracker implements ErrorTrackerInterface
{
    /**
     * @var ApiResponseTracker
     */
    protected $responseTracker;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var User
     */
    protected $user;

    /**
     * AbstractErrorTracker constructor.
     * @param ApiResponseTracker $responseTracker
     */
    public function __construct(ApiResponseTracker $responseTracker)
    {
        $this->responseTracker = $responseTracker;
    }


}