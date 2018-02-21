<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Validator;
use Storage;
use File;
use Input;

class PostController extends Controller
{
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
            $posts->slug = request()->input('title');
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
        $posts->slug = request()->input('title');
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
            $posts->categories()->sync($posts->cate,true);
        }
        $tag = request()->input('tag');
        foreach($tag as $tag_id){
            $posts->tag = $tag_id['id'];
            $posts->tags()->sync($posts->tag,true);
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
        $posts->categories()->detach();
        $posts->tags()->detach();

        return response_success([],'Posts Was Delete');
    }

}
