<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use JWTAuth;
use Validator;
use Storage;
use File;
use Input;
class DashboardController extends Controller
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

        return response_success([],'Categories was deleted');
    }

    /**
     * api/dashboard/posts | GET
     * get all posts
     */
    public function getAllPost() {
        $posts = Post::orderBy('created_at')->get();
        $categories = Category::select('id','category')->get();
        $tags = Tag::select('id','tag')->get();
        return response_success([
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    /**
     * api/dashboard/posts/{id}/categories | GET
     * get Categories of posts
     */
    public function getCate ($id) {
        $posts = Post::with(['categories'=>function($query) {
            $query->select('categories.id','category');
        },'tags' => function($query) {
            $query->select('tags.id','tag');
        }])->find($id);

        return response_success([
            'posts' => $posts
        ]);
    }


    /**
     * api/dashboard/posts | POST
     * create a post
     */
    public function createPost() {
        $rules = [
            'title' => 'required | unique:posts',
            'content' => 'required',
//            'image' => 'required | image'
        ];
        $input = request()->all();
        $validator = Validator::make($input,$rules);
        if($validator->fails()) {
            return response_error([],$validator);
        }else {

            $file_data= request()->input('image');
            $file_name = 'image_'.time().'.png';
            @list($type, $file_data) = explode(';', $file_data);
            @list(, $file_data) = explode(',', $file_data);
            $posts = new Post();
            $posts->title = request()->input('title');
            $posts->content = request()->input('content');
            $posts->image = request()->input('image');
            if($file_data!=""){
                $url = Storage::disk('uploads')->put($file_name,base64_decode($file_data));
            }
            $posts->author = getUser()->username;
            $posts->status_post = 0;
            $posts->save();
            $cate  = request()->input('cate');
            foreach ($cate as $cate_id) {
                $posts->cate = $cate_id['id'];
                $posts->categories()->attach($posts->cate);
            }
            $tag = request()->input('tag');
            foreach($tag as $tag_id){
                $posts->tag = $tag_id['id'];
                $posts->tags()->attach($posts->tag);
            }
            return response_success([
                'posts' => $posts
            ]);
        }
    }

    /**
     * api/dashboard/posts/{id} | PUT
     * update posts
     */
    public function updatePost ($id) {
        $file_data= request()->input('image');
        $file_name = 'image_'.time().'.png';
        @list($type, $file_data) = explode(';', $file_data);
        @list(, $file_data) = explode(',', $file_data);
        $user = JWTAuth::parseToken()->toUser();
        $posts = Post::find($id);
        $posts->title = request()->input('title');
        $posts->content = request()->input('content');
        $posts->image = request()->input('image');
        if($file_data!=""){ // storing image in storage/app/public Folder
             Storage::disk('uploads')->put($file_name,base64_decode($file_data));
        }

        $posts->author = $user->username;
        $posts->status_post = 0;
        $posts->save();
        $cate  = request()->input('cate');
        foreach ($cate as $cate_id) {
            $posts->cate = $cate_id['id'];
            $posts->categories()->sync($posts->cate,false);
        }
        $tag = request()->input('tag');
        foreach($tag as $tag_id){
            $posts->tag = $tag_id['id'];
            $posts->tags()->sync($posts->tag,false);
        }
        return response_success([
            'posts' => $posts
        ],'Post Was updated successfully');
    }

    /**
     * api/dashboard/posts/{id} | DELETE
     * delete a post
     */
    public function deletePost($id) {

        $posts = Post::find($id);
        $posts->delete();

        return response_success([],'Posts Was Delete');
    }

    /**
     * api/dashboard/tag | GET
     * get all tag
     */
    public function getTag() {
        $tag = Tag::orderBy('created_at')
            ->get();

        return response_success([
            'tags' => $tag
        ],'get all tag');
    }

    /**
     * api/dashboard/tag | post
     * create tag
     */
    public function createTag() {
        $rules = [
            'tag'=> 'required | unique:tags'
        ];
        $input = request()->all();
        $validator = Validator::make($input,$rules);

        if($validator->fails()) {
            return response_error([],$validator);
        }else {
            $tags = new Tag();
            $tags = $tags->fill(request()->all());
            $tags->save();

            return response_success([
                'tags' => $tags
            ],'create tag successfully');
        }

    }

    /**
     * api/dashboard/tag/{id} | put
     * update tag
     */
    public function updateTag ($id) {

        $tags = Tag::find($id);
        $tags = $tags->fill(request()->all());
        $tags->save();

        return response_success([
            'tags' => $tags
        ],'tag was updated');
    }

    /**
     * api/dashboard/tag/{id} | delete
     * delete tag
     */
    public function deleteTag ($id) {
        $tags = Tag::find($id);
        $tags->delete();

        return response_success([
        ],'tag was deleted');
    }
}
