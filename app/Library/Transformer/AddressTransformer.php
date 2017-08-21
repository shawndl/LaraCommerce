<?php
/*
|--------------------------------------------------------------------------
| AddressTransformer.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for receiving an addresses and returning an
| array including the street address, city, state, and postal code
*/

namespace App\Library\Transformer;


use App\Address;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AddressTransformer extends AbstractTransformer
{
    /**
     * returns a single address
     *
     * @param Model $address
     * @return array
     */
    public static function single(Model $address)
    {
        return [
            'id' => $address->id,
            'street_address' => $address->address,
            'city' => $address->city,
            'state' => $address->state->name,
            'state_id' => $address->state_id,
            'postal_code' => $address->postal_code
        ];
    }
}