<?php

namespace Tests\Browser\includes;

use App\Category;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AbstractIncludes extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * adds categories to the database
     *
     * @param array $array
     */
    protected function addCategories(array $array)
    {
        foreach ($array as $category)
        {
            factory(Category::class)->create(['name' => $category]);
        }
    }
}
