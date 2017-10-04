<?php
/*
|--------------------------------------------------------------------------
| DeleteCategoriesPageTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
|    In order to delete categories from the database
|    As an admin
|    I need to delete a category
|
| Scenario:
|   Given: I am an administrator
|   And: I want to delete category
|   When: I submit a delete request from the visit the 'admin/categories' page
|   Then: The category must be deleted
*/
namespace Tests\Browser\admin\categories;

use Tests\Browser\admin\AbstractDuskAdmin;
use Laravel\Dusk\Browser;

class DeleteCategoriesPageTest extends AbstractDuskAdmin
{
    /**
     * @group admin
     * @group categories
     * @test
     */
    public function the_admin_must_be_able_to_delete_a_category()
    {
        $user = $this->addUser(true);
        $this->addCategory(['name' => 'Phones']);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/admin/categories')
                ->assertSee('Categories Page')
                ->pause(500)
                ->press('Delete Category')
                ->pause('500')
                ->press('OK')
                ->pause(2000)
                ->assertSee('You deleted a category!')
                ->click('#close-icon')
                ->pause(1500)
                ->assertDontSee('Phones');
        });
        $this->assertDatabaseMissing('categories', [
           'name' => 'Phones'
        ]);
    }
}
