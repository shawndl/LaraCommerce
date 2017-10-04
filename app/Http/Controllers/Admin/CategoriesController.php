<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends AbstractAdminController
{
    /**
     * @var Category
     */
    protected $categories;

    /**
     * CategoriesController constructor.
     * @param Category $categories
     */
    public function __construct(Category $categories)
    {
        $this->categories = $categories;
        parent::__construct();

    }


    /**
     * Display all the categories details
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.index', [
            'table' => 'admin._includes._tables._categories'
        ]);
    }
}
