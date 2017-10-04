<?php
/*
|--------------------------------------------------------------------------
| SalesDateFormat.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for receiving a date string and returning a date
| formatted for the sales table
*/

namespace App\Library\Format;


class SalesDateFormat
{
    /**
     * returns a date formatted for the sales table
     *
     * @param \DateTime $date
     * @return string
     */
    public static function format(\DateTime $date)
    {
        return $date->format('Y-m-d');
    }
}