<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * api/homepages/posts | get
     * get all post
     */
    public function index() {
        $posts = Post::with(['categories'=>function($query) {
            $query->select('category');
        }])->orderBy('created_at','desc')
            ->get();
        return response_success( [
            'posts' => $posts
        ],'Get all post');
    }

    /**
     * api/homepages/posts/{id}/detail | get
     * get post by id
     */
    public function show($id) {
        $posts = Post::with(['categories'=>function($query) {
            $query->select('category');
        }])->find($id);

        return response_success([
            'posts' => $posts
        ],'get post by id');
    }

    /**
     * api/homepages/posts/{id}/counter | Post
     * counter visiter post
     */
    public function counter ($id) {
        $counter = request()->input('counter');
        $counter ++;
        $counter = Post::where('id',$id)->update(['counter'=>$counter]);

        return response_success([
            'counter' =>$counter
        ]);
    }

    /**
     * api/homepages/posts/popular | get
     * get post popular
     */
    public function popular () {
        $popular = Post::where(['status_post'=> 0])
            ->orderBy('counter','DESC')
            ->limit(6)
            ->get();

        return response_success([
            'popular' => $popular
        ],'get popular post');
    }

    /**
     * api/homepages/posts/recent | get
     * get post recent
     */
    public function recent() {
        $recent = Post::where(['status_post' => 0])
            ->orderBy('created_at','desc')
            ->limit(6)
            ->get();

        return response_success([
            'recent' => $recent
        ],'get recent post');
    }

    /**
     * api/posts/{keyword}/search| get
     * get post by category
     */
    public function search ($keyword) {
        $posts = Post::with('categories','tags')
            ->whereHas('categories',function($query) use ($keyword) {
                $query->select('category')
                    ->where('category','like','%'.$keyword.'%');
            })
            ->orWhereHas('tags',function($query) use ($keyword) {
                $query->select('tag')
                    ->where('tag','like','%'.$keyword.'%');
            })
            ->orderBy('created_at','desc')
            ->where(['status_post' => 0])
            ->get();

        return response_success([
            'posts' => $posts
        ],'get post by category');
    }

    /**
     * api/posts/{keyword}/tags | get
     * get post by tag
     */
//    public function postTag ($keyword) {
//        $posts = Post::with('tags','categories')
//            ->whereHas('tags',function($query) use ($keyword) {
//                $query->select('tag')
//                    ->where('tag','like','%'.$keyword.'%');
//            })
//            ->orderBy('created_at','desc')
//            ->where(['status_post' => 0])
//            ->get();
//
//        return response_success([
//            'posts' => $posts
//        ],'get post by category');
//    }
}
