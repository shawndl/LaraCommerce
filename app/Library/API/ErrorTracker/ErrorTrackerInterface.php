<?php
/*
|--------------------------------------------------------------------------
| ErrorTrackerInterface.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| An error tracker must be able to check for errors when creating, editing,
| and deleting.
*/

namespace App\Library\API\ErrorTracker;


use App\Library\API\ApiResponseTracker;
use App\User;
use Illuminate\Database\Eloquent\Model;

interface ErrorTrackerInterface
{
    /**
     * checks for errors when creating
     *
     * @param Model $model
     * @return ApiResponseTracker
     */
    public function create(Model $model);

    /**
     * checks for errors when updating
     *
     * @param Model $model
     * @param User $user
     * @return ApiResponseTracker
     */
    public function update(Model $model, User $user);

    /**
     * checks for errors when deleting
     *
     * @param Model $model
     * @param User $user
     * @return ApiResponseTracker
     */
    public function delete(Model $model, User $user);
}