<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->paginate(20);

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post) // manual key fetching in route binding
    {
        $post->load(['tags', 'user']);

        return view('posts.show', compact('post'));
    }
}
