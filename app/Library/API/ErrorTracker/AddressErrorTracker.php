<?php
/*
|--------------------------------------------------------------------------
| AddressErrorTracker.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for receiving an ApiTracker and an Address and
| checking for api errors
*/

namespace App\Library\API\ErrorTracker;


use App\Address;
use App\Library\API\ApiResponseTracker;
use App\User;
use Illuminate\Database\Eloquent\Model;

class AddressErrorTracker extends AbstractErrorTracker
{
    /**
     * checks if there are any user errors
     *
     * @param Model $model
     * @param User $user
     * @return ApiResponseTracker
     */
    public function update(Model $model, User $user)
    {
        $this->model = $model;
        $this->user = $user;
        $this->addressExists();
        $this->belongsToUser();
        return $this->responseTracker;
    }

    /**
     * checks for errors when creating
     *
     * @param Model $model
     * @return ApiResponseTracker
     */
    public function create(Model $model)
    {
        // TODO: Implement create() method.
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
        $this->addressExists();
        $this->belongsToUser();
        return $this->responseTracker;
    }

    /**
     * does the address exist
     *
     * @return void
     */
    protected function addressExists()
    {
        if(!$this->model->hasResult())
        {
            $this->responseTracker->setResult(422,
                "Error: there is no address in your account that matches the one you provided!",
                true);
        }
    }
}