<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";
    protected $fillable = ['id','category','description','created_at'];
    public function posts() {
        return $this->belongsToMany('App\Models\Post','cate_post','cate_id','post_id')
            ->select('posts.id','status_post','title','image','content','author','posts.created_at');
    }
}
