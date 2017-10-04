<?php
/*
|--------------------------------------------------------------------------
| UserAccountTransformer.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for receiving a User object and returning an
| array of the users information including accounts, orders, and addresses
*/

namespace App\Library\Transformer;


use App\User;

class UserAccountTransformer
{
    /**
     * @var User
     */
    protected static $user;

    /**
     * returns an array of user account information
     *
     * @param User $user
     * @return array
     */
    public static function transform(User $user)
    {
        return [
            'user' => UserTransformer::single($user),
            'addresses' => AddressTransformer::transform($user->addresses),
            'orders'    => OrderTransformers::transform($user->orders)
        ];
    }
}