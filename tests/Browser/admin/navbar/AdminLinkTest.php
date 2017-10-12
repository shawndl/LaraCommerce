<?php
/*
|--------------------------------------------------------------------------
| AdminLinkTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to provide administrators easy access to the admin site
|    As a Admin
|    I need visit the admin site
|
| Scenario:
|   Given: I am an admin
|   And: I am logged in
|   When: I am on the user page
|   Then: I should see a link to the admin site on the navbar
*/
namespace Tests\Browser\admin\navbar;

use App\User;
use Tests\Browser\admin\AbstractDuskAdmin;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminLinkTest extends AbstractDuskAdmin
{
    /**
     * @group navbar
     * @group admin
     * @test
     */
    public function an_admin_must_have_easy_access_to_the_admin_site()
    {
        $this->addUser(true);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                ->visit('/')
                ->assertSee('Admin Page')
                ->click('#admin-page')
                ->assertSee('Users Page')
                ->assertSee('Products Page')
                ->assertSee('Orders Page')
                ->assertSee('Categories Page')
                ->assertSee('Taxes Page');
        });
    }
}
