<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreatePostRequest;
use App\Http\Requests\Admin\EditPostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(): View
    {
        // $posts = Post::with('category')->paginate(20);
        $posts = Post::withOptionalCategory(10)->get(); // Conditional Scope using when()

        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        $categories = Category::all();

        return view('admin.posts.create', compact('categories'));
    }

    public function store(CreatePostRequest $request)
    {
        $tags = explode(',', $request->input('tags'));

        if ($request->has('image')) {
            $filename = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('uploads', $filename, 'public');
        }

        $post = auth()->user()->posts()->create([
            'title' => $request->string('title'),
            'image' => $filename ?? null,
            'post' => $request->string('post'),
            'category_id' => $request->integer('category'),
        ]);

        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $post->tags()->attach($tag);
        }

        return redirect()->route('admin.posts.index')
            ->with('status', 'Post created successfully.');
    }

    public function edit(Post $post): View
    {
        $post->load('tags'); // Use load() when you already have the model but need extra relationships dynamically.
        $categories = Category::all();
        $tags = $post->tags->implode('name', ', ');

        return view('admin.posts.edit', compact('tags', 'categories', 'post'));
    }

    public function update(EditPostRequest $request, Post $post)
    {
        $tags = explode(',', $request->input('tags'));

        if ($request->has('image')) {
            Storage::delete('public/uploads/'.$post->image);

            $filename = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('uploads', $filename, 'public');
        }

        $post->update([
            'title' => $request->string('title'),
            'image' => $filename ?? $post->image,
            'post' => $request->string('post'),
            'category_id' => $request->integer('category'),
        ]);

        $newTags = [];
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            array_push($newTags, $tag->id);
        }
        $post->tags()->sync($newTags);

        return redirect()->route('admin.posts.index')
            ->with('status', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::delete('public/uploads/'.$post->image);
        }

        $post->tags()->detach();
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('status', 'Post deleted successfully.');
    }
}
