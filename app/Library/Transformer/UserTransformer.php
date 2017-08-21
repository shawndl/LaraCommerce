<?php
/*
|--------------------------------------------------------------------------
| UserTransformer.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for returning an array of user information that is
| that should not contain any sensitive information
| 1) user email
| 2) username
*/

namespace App\Library\Transformer;


use App\User;
use Illuminate\Support\Facades\Auth;

class UserTransformer
{
    /**
     * @var User
     */
    protected static $user;

    /**
     * sets the users information
     *
     * @param User $user
     * @return array|bool
     */
    public static function transform(User $user)
    {
        return [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email'     => $user->email,
            'username'  => $user->username
        ];
    }
}