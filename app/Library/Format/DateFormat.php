<?php
/*
|--------------------------------------------------------------------------
| DateFormat.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for receiving a time and returning a formatted
| date
*/

namespace App\Library\Format;


use Faker\Provider\DateTime;

class DateFormat
{
    protected static $timesAvailable = [
        'y' => 'year',
        'm' => 'month',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second'
    ];

    protected static $bestInterval = [];

    /**
     * returns a formatted days ago string using the date that was passed in
     *
     * @param $date
     * @return string
     */
    public static function daysAgo($date)
    {
        self::setBestTime($date);
        self::isPlural();
        return self::getTime();
    }

    /**
     * sets the best time by determining what is the largest time interval
     *
     * @return void
     */
    protected static function setBestTime($date)
    {
        $now = new \DateTime();
        $ago = new \DateTime($date);
        $difference = $now->diff($ago);

        foreach (self::$timesAvailable as $key => $value)
        {
            if($difference->$key)
            {
                self::$bestInterval = [
                    'interval' => $value,
                    'time' => $difference->$key
                ];
                break;
            }
        }
    }

    /**
     * if the time difference is greater that 1 then add s to the interval
     *
     * @return void
     */
    protected static function isPlural()
    {
        if(self::$bestInterval['time'] > 1)
        {
            self::$bestInterval['interval'] =  self::$bestInterval['interval'] . 's';
        }
    }

    /**
     * formats a string with the time interval and time are together
     * e.g: 4 days ago
     *
     * @return string
     */
    protected static function getTime()
    {
        return self::$bestInterval['time'] . ' ' .  self::$bestInterval['interval'] . ' ago';
    }
}