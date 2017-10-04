<?php
/*
|--------------------------------------------------------------------------
| ViewTaxAPITest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order for pages to receive information about all taxes
|    As an admin
|    I need to view all taxes
|
| Scenario:
|   Given: I am an app
|   And I need information about taxes available
|   When: I send a get request
|   Then: I must receive a json object with that data
*/
namespace Tests\Feature\acceptance\admin\tax;

use App\Tax;
use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;

class ViewTaxAPITest extends AbstractHttpAjaxTestClass
{
    protected $getRoute = 'admin/api/taxes';

    /**
     * @group tax
     * @group acceptance
     * @test
     */
    public function only_admins_can_receive_results_this_page()
    {
        $this->get($this->getRoute)
            ->assertRedirect('login');
    }

    /**
     * @group tax
     * @group acceptance
     * @test
     */
    public function it_must_return_all_the_categories()
    {
        $taxes = factory(Tax::class, 5)->create();
        $this->setGetResponseAdmin();
        foreach ($taxes as $tax)
        {
            $this->getResponse->assertJsonFragment([
                'id' => $tax->id,
                'name' => $tax->name,
                'description' => $tax->description
            ]);
        }


    }
}
