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

    protected $models = ['address', 'order', 'user'];

    /**
     * AbstractErrorTracker constructor.
     * @param ApiResponseTracker $responseTracker
     */
    public function __construct(ApiResponseTracker $responseTracker)
    {
        $this->responseTracker = $responseTracker;
    }

    /**
     * can dynamically add more models
     *
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if(in_array($name, $this->models) && $value instanceof Model)
        {
            $this->{$name} = $value;
        }
    }

    /**
     * does the model belong to the user
     *
     * @return void
     */
    protected function belongsToUser()
    {

        if((int)$this->model->user_id !== (int)$this->user->id)
        {
            $this->responseTracker->setResult(403,
                "Error: You are not authorized to perform this action", true);
        }
    }

}