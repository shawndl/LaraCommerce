<?php
/*
|--------------------------------------------------------------------------
| ViewCategoriesPageTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order administer categories
|    As an admin
|    I need to view all categories
|
| Scenario:
|   Given: I am an administrator
|   And: I want to view all my categories
|   When: I visit 'admin/categories/
|   Then: I must be able to see all categories
*/
namespace Tests\Browser\admin\categories;

use Tests\Browser\admin\AbstractDuskAdmin;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ViewCategoriesPageTest extends AbstractDuskAdmin
{
    /**
     * @group admin
     * @group categories
     * @test
     */
    public function the_admin_must_be_able_to_view_all_categories()
    {
        $user = $this->addUser(true);
        $category1 = $this->addCategory();
        $category2 = $this->addCategory();
        $category3 = $this->addCategory();

        $this->browse(function (Browser $browser) use ($user, $category1, $category2, $category3) {
            $browser->loginAs($user)
                ->visit('/admin/categories')
                ->assertSee('Categories Page')
                ->pause(800)
                ->assertSee($category1->name)
                ->assertSee($category2->name)
                ->assertSee($category3->name);
        });
    }
}
