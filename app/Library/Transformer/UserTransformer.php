<?php
/*
|--------------------------------------------------------------------------
| UserTransformer.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for returning an array of user information that is
| that should not contain any sensitive information
*/

namespace App\Library\Transformer;


use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserTransformer extends AbstractTransformer
{
    /**
     * @param Model $model
     * @return array
     */
    public static function single(Model $model)
    {
        return [
            'id' => $model->id,
            'first_name' => $model->first_name,
            'last_name' => $model->last_name,
            'email'     => $model->email,
            'username'  => $model->username
        ];
    }
}