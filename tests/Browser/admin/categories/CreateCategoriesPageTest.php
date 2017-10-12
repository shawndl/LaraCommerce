<?php
/*
|--------------------------------------------------------------------------
| CreateCategoriesPageTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to add categories to the database
|    As an admin
|    I need to create a new category
|
| Scenario:
|   Given: I am an administrator
|   And: I want to create a new category
|   When: I submit a new category request from the visit the 'admin/categories' page
|   Then: A new category must be created
*/
namespace Tests\Browser\admin\categories;


use Tests\Browser\admin\AbstractDuskAdmin;
use Laravel\Dusk\Browser;

class CreateCategoriesPageTest extends AbstractDuskAdmin
{
    /**
     * @group admin
     * @group categories
     * @test
     */
    public function the_admin_must_be_able_to_view_all_categories()
    {
        $user = $this->addUser(true);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/admin/categories')
                ->assertSee('Categories Page')
                ->pause(1000)
                ->type('category_name', 'food')
                ->press('Add')
                ->pause('2000')
                ->assertSee('You have created a new category!')
                ->assertSee('Food');
        });
    }
}
