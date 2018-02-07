<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    protected $table = "posts";

    protected $fillable = ['id','title','content','image','created_at','counter'];

    protected $appends = ['time_post'];

    public function categories() {
        return $this->belongsToMany('App\Models\Category','cate_post','post_id','cate_id')
            ->select('categories.id','category');
    }

    public function comments() {
        return $this->hasMany('App\Models\Comment','post_id','id');
    }

    public function tags() {
        return $this->belongsToMany('App\Models\Tag','post_tag','post_id','tag_id');
    }
    
    public function getTimePostAttribute() {
         $current = $this->created_at;
         $dt =  Carbon::createFromTimeStamp(strtotime($current))->diffForHumans();
        return $dt;
    }
}
