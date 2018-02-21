<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

use Validator;

class CategoryController extends Controller
{
    /**
     * api/dashboard/categories | GET
     * get all categories
     */
    public function getCategories() {
        $categories = Category::orderBy('created_at')
            ->get();

        return response_success([
            'categories' => $categories
        ]);
    }

    /**
     * api/dashboard/categories | POST
     * create a catetories
     */
    public function createCategories() {
        $rules = [
            'category' => 'required | unique:categories',
            'description' => 'required'
        ];

        $messages = [
            'category.required' => 'Please enter category',
            'category.unique' => 'Category exists',
            'description' => 'Please enter Description'
        ];
        $input =request()->all();
        $validator = Validator::make($input, $rules,$messages);
        if($validator->fails()) {
            return response_error([],$messages);
        }else {
            $categories = new Category();
            $categories = $categories->fill(request()->all());
            $categories->slug = str_slug(request()->input('category'),"-");
            $categories->save();

            return response_success([
                'categories' => $categories
            ], 'Categories was created');
        }
    }

    /**
     * api/dashboard/categories/{id} | PUT
     * update a categories
     */
    public function updateCategories($id) {

        $categories = Category::find($id);
        $categories = $categories->fill(request()->all());
        $categories->slug = str_slug(request()->input('category'),"-");
        $categories -> save();

        return response_success([
            'categories' => $categories
        ],'Categories updated successfully');
    }

    /**
     * api/dashboard/categories/{id} | DELETE
     * delete a categories
     */
    public function deleteCategories($id) {

        $categories = Category::find($id);
        $categories->delete();
        $categories->posts()->detach();

        return response_success([],'Categories was deleted');
    }

}
