<?php

namespace Tests\Feature\unit\classes;

use App\Library\Format\DateFormat;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DateFormatTest extends TestCase
{
    /**
     * @test
     * @group unit
     */
    public function it_must_be_able_to_return_the_largest_interval_of_time()
    {

    }

    /**
     * @test
     * @group unit
     */
    public function it_must_be_able_to_return_how_many_minutes_ago()
    {
        $time = $this->getDate('PT10M');
        $this->assertEquals('10 minutes ago', DateFormat::daysAgo($time));
    }

    /**
     * @test
     * @group unit
     */
    public function it_must_be_able_to_return_how_many_hours_ago()
    {
        $time = $this->getDate('PT10H');
        $this->assertEquals('10 hours ago', DateFormat::daysAgo($time));
    }

    /**
     * @test
     * @group unit
     */
    public function it_must_be_able_to_return_how_many_days_ago()
    {
        $time = $this->getDate('P5D');
        $this->assertEquals('5 days ago', DateFormat::daysAgo($time));
    }

    /**
     * @test
     * @group unit
     */
    public function it_must_be_able_to_return_how_many_months_ago()
    {
        $time = $this->getDate('P3M');
        $this->assertEquals('3 months ago', DateFormat::daysAgo($time));
    }

    /**
     * @test
     * @group unit
     */
    public function it_must_be_able_to_return_how_many_years_ago()
    {
        $time = $this->getDate('P3Y');
        $this->assertEquals('3 years ago', DateFormat::daysAgo($time));
    }

    /**
     * returns a date in the past based on the datetime interval format
     *
     * @param $timeAgo
     * @return string
     */
    private function getDate($timeAgo)
    {
        $date = new \DateTime();
        $date->sub(new \DateInterval($timeAgo));
        return $date->format('Y-m-d H:i:s');
    }
}
