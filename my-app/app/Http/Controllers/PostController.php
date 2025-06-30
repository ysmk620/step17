<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function create()
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:20',
            'body' => 'required|max:400',
        ]);

        $request->user()->posts()->create($validated);

        return back()->with('message', '保存しました');
    }

    public function index()
    {
        // $posts = Post::with('user')->get();
        $posts = Post::with('user')
            ->withCount('likes')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('post.index', compact('posts'));
    }


    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('post.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
{
    $this->authorize('update', $post);

    $validated = $request->validate([
        'title' => 'required|max:20',
        'body'  => 'required|max:400',
    ]);

    $post->update($validated);

    return back()->with('message', '更新しました');
}

    public function destroy(Request $request, post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        $request->session()->flash('message', '削除しました');
        return redirect()->route('post.index');
    }
}
