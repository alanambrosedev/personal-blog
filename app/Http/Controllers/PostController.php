<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->paginate(20);

        return view('posts.index', ['posts' => $posts]);
    }

    public function show(string $id)
    {
        $post = Post::with('tags', 'user')->findOrFail($id);

        return view('posts.show', ['post' => $post]);
    }
}
