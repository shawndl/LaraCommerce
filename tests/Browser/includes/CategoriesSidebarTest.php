<?php

namespace Tests\Browser\includes;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoriesSidebarTest extends AbstractIncludes
{
    /**
     * @test
     * @group includes
     */
    public function categories_must_appear_in_the_side_bar()
    {
        $this->addCategories(['Clothes', 'Electronics', 'Food']);
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSeeIn('.list-group', 'Clothes')
                ->assertSeeIn('.list-group', 'Electronics')
                ->assertSeeIn('.list-group', 'Food');
        });
    }

    /**
     * @test
     * @group includes
     */
    public function the_navbar_must_have_a_categories_tab_if_the_size_is_under_979()
    {
        $this->addCategories(['Clothes', 'Electronics', 'Food']);
        $this->browse(function (Browser $browser) {
            $browser->resize(800, 768)
                ->clickLink('Categories')
                ->assertSeeIn('#navbar-category li a', 'Clothes')
                ->assertSeeIn('#navbar-category li:nth-child(2)', 'Electronics')
                ->assertSeeIn('#navbar-category li:nth-child(3)', 'Food');
        });
    }
}
