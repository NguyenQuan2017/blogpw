<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;


class TagController extends Controller
{
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
            $tags->slug = str_slug(request()->input('tag'),"-");
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
        $tags->slug = str_slug(request()->input('tag'),"-");
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
        $tags->posts()->detach();
        return response_success([
        ],'tag was deleted');
    }
}
