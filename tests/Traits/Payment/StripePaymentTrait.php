<?php
use Stripe\Stripe;
use Stripe\Token;

/**
 * Created by PhpStorm.
 * User: shawnlegge
 * Date: 12/8/17
 * Time: 1:34 PM
 */
trait StripePaymentTrait
{
    protected $token;

    protected $cards = [
        'visa' => '4242424242424242',
        'visaDebit' => '4000056655665556',
        'master' => '5555555555554444',
        'masterDebit' => '5200828282828210',
        'american' => '378282246310005',
        'discover' => '6011111111111117'
    ];

    /**
     * @var array
     */
    protected $cardErrors = [
        'addressFail' => '4000000000000028',
        'zipCodeFail' => '4000000000000036',
        'zipAndAddressUnavailable' => '4000000000000044',
        'cvcFails' => '4000000000000101',
        'declined' => '4000000000000002',
        'fraud' => '4100000000000019',
        'incorrectCvc' => '4000000000000127',
        'cardExpired' => '4000000000000069',
        'processError' => '4000000000000119',
        'highRiskCard' => '4100000000000019',
        'elevatedRiskCard' => '4000000000009235'

    ];

    protected $stripeError;

    /**
     * @var string
     */
    protected $card;

    public function __call($name, $arguments)
    {
        if(array_key_exists($name, $this->cardErrors))
        {
            $this->card = $this->cardErrors[$name];
            return;
        }

        if(array_key_exists($name, $this->cards))
        {
            $this->card = $this->cards[$name];
        }
    }

    public function setUpToken()
    {
        Stripe::setApiKey(env('STRIPE_KEY'));

        $card = [
            'number' => $this->card,
            'exp_month' => 1,
            'exp_year' => 2020,
            'cvc' => 123
        ];
        try {
            $this->token = Token::create(['card' => $card])->id;
        } catch (Exception $exception) {
            $this->stripeError = $exception->getMessage();
        }

    }
}