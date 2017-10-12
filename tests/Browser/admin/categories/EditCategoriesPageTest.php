<?php
/*
|--------------------------------------------------------------------------
| EditCategoriesPageTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
|    In order to edit categories from the database
|    As an admin
|    I need to edit a category
|
| Scenario:
|   Given: I am an administrator
|   And: I want to edit category
|   When: I submit an update request from the visit the 'admin/categories' page
|   Then: The category must be updated
*/
namespace Tests\Browser\admin\categories;

use Tests\Browser\admin\AbstractDuskAdmin;
use Laravel\Dusk\Browser;

class EditCategoriesPageTest extends AbstractDuskAdmin
{
    /**
     * @group admin
     * @group categories
     * @test
     */
    public function the_admin_must_be_able_to_edit_categories()
    {
        $user = $this->addUser(true);
        $this->addCategory(['name' => 'Phones']);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/admin/categories')
                ->assertSee('Categories Page')
                ->pause(800)
                ->press('Edit Category')
                ->pause('500')
                ->type('category_name_Phones', 'Chocolate')
                ->press('Edit')
                ->pause(2000)
                ->assertSee('You edited the Chocolate category!')
                ->pause(1500)
                ->assertSee('Chocolate');
        });
    }
}
