<?php

namespace Tests\Feature\unit\classes;

use App\Library\Format\SalesDateFormat;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SalesDateFormatTest extends TestCase
{
    /** @test */
    public function it_must_return_a_formatted_date()
    {
        $formatDate = SalesDateFormat::format(new \DateTime('2017-09-21'));
        $this->assertEquals('2017-09-21', $formatDate);

    }

    /** @test */
    public function it_must_return_the_correct_date()
    {
        $formatDate = SalesDateFormat::format(new \DateTime('1st Oct 2017'));
        $this->assertEquals('2017-10-01', $formatDate);
    }
}
