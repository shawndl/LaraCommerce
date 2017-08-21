<?php
/*
|--------------------------------------------------------------------------
| ShippingDateEstimator.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for returning an estimated arrival date for an
| order
*/

namespace App\Library\Order;



class ShippingDateEstimator
{
    /**
     * Returns the estimated arrival date
     *
     * @param \DateTime $date
     * @param int $numberOfDays
     * @return string
     */
    public static function arrivalDate(\DateTime $date, $numberOfDays = 10)
    {
        $date->add(new \DateInterval(self::formatTimeInterval($numberOfDays)));
        return $date->format('M jS, Y');
    }

    /**
     * creates a datetime interval format based on the number of days
     *
     * @param $numberOfDays
     * @return string
     */
    private static function formatTimeInterval($numberOfDays)
    {
        return 'P' . $numberOfDays . 'D';
    }
}