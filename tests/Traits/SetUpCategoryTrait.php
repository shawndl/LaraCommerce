<?php

/**
 * Created by PhpStorm.
 * User: shawnlegge
 * Date: 10/8/17
 * Time: 10:36 AM
 */
trait SetUpCategoryTrait
{
    /**
     * @var \App\Category
     */
    protected $category;

    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $categories;

    private $newCategories = ['electronics', 'furniture'];

    public function setUpCategory()
    {
        \App\Category::truncate();
        $this->category = \App\Category::create([
            'name'=> 'clothes'
        ]);
    }

    /**
     * add categories
     *
     * @return void
     */
    public function addCategories()
    {
        foreach ($this->newCategories as $category)
        {
            \App\Category::create([
                'name'=> $category
            ]);
        }
        $this->categories = \App\Category::all();
    }
}