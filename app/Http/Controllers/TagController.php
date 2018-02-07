<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index () {
        $tags = Tag::all();

        return response_success([
            'tags' => $tags
        ],'get all tag');
    }
}