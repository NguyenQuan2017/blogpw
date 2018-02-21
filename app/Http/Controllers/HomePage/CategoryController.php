<?php

namespace App\Http\Controllers\HomePage;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * api/category | get
     * get category
     */
    public function index() {
        $categories = Category::withCount(['posts'=>function($query) {
            $query->where(['status_post' => 0]);
        }])
            ->orderBy('created_at')
            ->get();

        return response_success([
            'categories' => $categories
        ]);
    }

}
