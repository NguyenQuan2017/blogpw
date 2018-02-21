<?php

namespace App\Http\Controllers\HomePage;

use App\Models\Tag;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function index () {
        $tags = Tag::all();

        return response_success([
            'tags' => $tags
        ],'get all tag');
    }
}
