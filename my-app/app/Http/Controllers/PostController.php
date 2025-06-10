<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function create(){
        return view('post.create');
    }

    public function store(Request $request){
    $validated = $request->validate([
        'title' => 'required|max:20',
        'body' => 'required|max:400',
    ]);

    $validated['user_id'] = auth()->id();

    Post::create($validated);

    return back()->with('message', '保存しました');
    }

    public function index(){
        $posts = Post::with('user')->get();
        return view('post.index',compact('posts'));
    }

    public function show(Post $post){
        return view('post.show',compact('post'));
    }

    public function edit(Post $post){
        return view('post.edit',compact('post'));
    }

    public function update(Request $request,Post $post){
    $validated = $request->validate([
        'title' => 'required|max:20',
        'body' => 'required|max:400',
    ]);

    $validated['user_id'] = auth()->id();

    $post->update($validated);

    return back()->with('message', '更新しました');
    }

}
