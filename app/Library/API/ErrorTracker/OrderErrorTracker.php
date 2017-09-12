<?php
/*
|--------------------------------------------------------------------------
| OrderErrorTracker.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for tracking errors when a user creates or edits
| an order
*/

namespace App\Library\API\ErrorTracker;


use App\Address;
use App\Library\API\ApiResponseTracker;
use App\User;
use Illuminate\Database\Eloquent\Model;

class OrderErrorTracker extends AbstractErrorTracker
{

    /**
     * checks for errors when creating
     *
     * @param Model $model
     * @return ApiResponseTracker
     */
    public function create(Model $model)
    {
        $this->model = $model;
        $this->arePropertiesSet();
        $this->addressBelongsToUser();
        return $this->responseTracker;
    }

    /**
     * checks for errors when updating
     *
     * @param Model $model
     * @param User $user
     * @return ApiResponseTracker
     */
    public function update(Model $model, User $user)
    {
        $this->model = $model;
        $this->user = $user;
        $this->arePropertiesSet();
        $this->orderBelongsToUser();
        $this->addressBelongsToUser();
        return $this->responseTracker;
    }

    /**
     * checks for errors when deleting
     *
     * @param Model $model
     * @param User $user
     * @return ApiResponseTracker
     */
    public function delete(Model $model, User $user)
    {
        $this->model = $model;
        $this->user = $user;
    }

    /**
     * does the address belong to the user
     *
     * @return void
     */
    protected function addressBelongsToUser()
    {
        if((int)$this->address->user_id !== (int)$this->user->id)
        {
            $this->responseTracker->setResult(422,
                "Error: we are unable to process your request",
                true);
        }
    }

    /**
     * does the order belong to the user
     *
     * @return void
     */
    protected function orderBelongsToUser()
    {
        if((int)$this->model->user_id !== (int)$this->user->id)
        {
            $this->responseTracker->setResult(403,
                "Error: we are unable to process your request",
                true);
        }
    }

    /**
     * checks if the correct properties have been set
     *
     * @throws \Exception
     */
    protected function arePropertiesSet()
    {
        $error = 'Error: ' . __CLASS__ . ' requires ';
        if(!isset($this->address))
        {
            $error .= 'an ' . Address::class . ' property to be set';
            throw new \Exception($error);
        }
        if(!isset($this->user))
        {
            $error .= 'an ' . User::class . ' property to be set';
            throw new \Exception($error);
        }
    }
}