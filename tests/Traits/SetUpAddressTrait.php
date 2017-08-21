<?php
use App\Address;
use App\State;
use App\User;

/**
 * Created by PhpStorm.
 * User: shawnlegge
 * Date: 9/8/17
 * Time: 2:23 PM
 */
trait SetUpAddressTrait
{
    use SetUpUserTrait;

    /**
     * @var array
     */
    private $predefinedAddresses = [
        [
            'address' => '123 Fake St.',
            'city' => 'Springfield',
            'postal_code' => '27299'
        ],
        [
            'address' => '88 Liverpool Ln',
            'city' => 'Liverpool',
            'postal_code' => '27000'
        ],
        [
            'address' => '8 Princeton Rd.',
            'city' => 'Boston',
            'postal_code' => '93792'
        ]
    ];

    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $addresses;

    /**
     * @var State
     */
    protected $state;

    /**
     * creates an address for testing
     * can specify the user
     *
     * @return void
     */
    public function setUpAddress()
    {
        $this->setUpUser();
        $this->setUpState();
        foreach ($this->predefinedAddresses as $addressDetails)
        {
            $address = new Address();
            $address->user_id = $this->user->id;
            $address->state_id = $this->state->id;
            $address->address = $addressDetails['address'];
            $address->city = $addressDetails['city'];
            $address->postal_code = $addressDetails['postal_code'];
            $address->save();
        }
        $this->addresses = Address::all();
    }

    /**
     * returns how many address is assigned to a user
     *
     * @return integer
     */
    protected function countAddresses()
    {
        return Address::count();
    }

    /**
     * gets all addresses
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    protected function getAllAddresses()
    {
        return Address::all();
    }

    /**
     * adds a state
     */
    protected function setUpState()
    {
        State::truncate();
        $this->state = State::create([
            'name' => 'Colorado',
            'abbreviation' => 'Co'
        ]);
    }
}