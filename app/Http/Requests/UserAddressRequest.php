<?php

namespace App\Http\Requests;

use App\Address;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserAddressRequest extends FormRequest
{
    /**
     * @var string -- regular expression for address
     */
    protected $addressRegExp = "/^[A-Za-z0-9.\\s\\/]+$/";

    /**
     * @var string -- regular expression for postal code
     */
    protected $postalCodeRegExp = "/^\\d{5}([\\-]?\\d{4})?$/";

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'street_address' => "required|regex:$this->addressRegExp",
            'state' => 'required|numeric',
            'city' => 'required|alpha_spaces',
            'postal_code' => "required|regex:$this->postalCodeRegExp"
        ];
    }

    /**
     * creates an address
     *
     * @param Address $address
     * @return {void}
     */
    public function createAddress(Address $address)
    {
        $address->user_id = Auth::user()->id;
        $this->saveAddress($address);

    }

    /**
     * update an address
     * @param Address $address
     *
     * @return string
     */
    public function updateAddress(Address $address)
    {
        $this->saveAddress($address);
        return 'You have updated your address';

    }

    /**
     * saves the values to the database
     * @param Address $address
     * @return void
     */
    private  function saveAddress(Address $address)
    {
        $address->address = $this->request->get('street_address');
        $address->state_id = $this->request->get('state');
        $address->postal_code = $this->request->get('postal_code');
        $address->city = $this->request->get('city');
        $address->save();
    }
}
