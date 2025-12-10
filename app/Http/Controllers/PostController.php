<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // 一覧表示
    public function index() {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    // 登録画面表示
    public function create() {
        return view('posts.create');
    }

    //新規登録処理
    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required | max:20',
            'body' => 'required | max:400',
        ]);
        // dd(auth());
        $validated['user_id'] = auth()->id();

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
