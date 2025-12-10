<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function create() {
        return view('posts.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required | max:20',
            'body' => 'required | max:400',
        ]);

        $post = Post::create($validated);
        // バリデーション処理前の記述
        // $post = Post::create([
        //     'title' => $request->title,
        //     'body' => $request->body,
        // ]);

        $request->session()->flash('message', '保存しました。');
        return back();
    }
}
