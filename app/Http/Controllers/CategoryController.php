<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

    /**
     * api/category/{keyword}/post | get
     * get post by category
     */
//    public function post ($keyword) {
//        $posts = Post::with('categories')
//            ->whereHas('categories',function($query) use ($keyword) {
//                $query->select('category')->where('category','like','%'.$keyword.'%');
//            })->orderBy('created_at','desc')->where(['status_post' => 0])->get();
//        return response_success([
//            'posts' => $posts
//        ],'get post by category');
//    }
}
