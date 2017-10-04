<?php

namespace App\Http\Controllers\Admin\API;

use App\Category;
use App\Http\Controllers\Admin\AbstractAdminController;
use App\Http\Controllers\Traits\APIControllerTrait;
use App\Http\Requests\CategoryFormRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesAPIController extends AbstractAdminController
{
    use APIControllerTrait;
    /**
     * @var Category
     */
    protected $categories;

    /**
     * CategoriesAPIController constructor.
     * @param Category $categories
     */
    public function __construct(Category $categories)
    {
        $this->categories = $categories;
        parent::__construct();
    }

    /**
     * gets all categories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $categories =  $this->categories->all();
        } catch (\Exception $exception) {
            return $this->processingError();
        }

        return response()->json([
            'categories' => $categories
        ], 200);
    }

    /**
     *  creates a new category in the database
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryFormRequest $request)
    {
        try {
            $this->categories->create([
                'name' => $request->name
            ]);
        } catch(\Exception $exception) {
            return $this->processingError();
        }

        return response()->json([
            'message' => 'You have created a new category!'
        ], 200);
    }

    public function update(CategoryFormRequest $request, Category $category)
    {
        try {
            $category->update([
                'name' => $request->name
            ]);
        } catch (\Exception $exception) {
            return $this->processingError();
        }

        return $this->jsonMessage("You edited the $category->name category!");
    }

    /**
     * deletes a category
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
        } catch (\Exception $exception) {
            return $this->processingError();
        }

        return $this->jsonMessage('You deleted a category!');
    }
}
