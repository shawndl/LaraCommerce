<?php

namespace Tests\Feature\acceptance\admin\sale;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateSaleFailValidationTest extends AbstractTestSale
{
    /**
     * @group sales
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_start_date_is_required()
    {
        $this->post['start'] = '';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The start field is required.']);
    }

    /**
     * @group sales
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_start_date_must_be_a_date()
    {
        $this->post['start'] = 'tomorrow';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The start is not a valid date.']);
    }

    /**
     * @group sales
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_finish_date_is_required()
    {
        $this->post['finish'] = '';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The finish field is required.']);
    }

    /**
     * @group sales
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_finish_date_must_be_a_date()
    {
        $this->post['finish'] = 'tomorrow';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The finish is not a valid date.']);
    }

    /**
     * @group sales
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_product_id_is_required()
    {
        $this->post['product_id'] = '';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The product id field is required.']);
    }

    /**
     * @group sales
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_discount_is_required()
    {
        $this->post['discount'] = '';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The discount field is required.']);
    }

    /**
     * @group sales
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_discount_must_be_a_decimal()
    {
        $this->post['discount'] = '22';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The discount format is invalid.']);
    }
}
