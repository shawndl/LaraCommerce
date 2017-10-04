<?php

namespace Tests\Feature\acceptance\admin\sale;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EditSaleFailAuthTest extends AbstractTestSale
{
    /**
     * @group sales
     * @group admin
     * @group acceptance
     * @test
     */
    public function guests_can_not_submit_this_form()
    {
        $this->setPostResponse(['_method' => 'PATCH']);
        $this->postResponse->assertStatus(401);
    }

    /**
     * @group sales
     * @group admin
     * @group acceptance
     * @test
     */
    public function users_that_are_not_admin_can_not_submit_this_form()
    {
        $this->setPostResponseUser(['_method' => 'PATCH']);
        $this->postResponse->assertStatus(302);
    }
}
