<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    // 一覧表示
    public function index() {
        // 条件に限らず全データを取得する
        $posts = Post::all();
        // ログインしているユーザーのデータのみ取得
        // $posts = Post::where('user_id', auth()->id()) -> get();
        // $posts = Post::where('user_id', '!=', auth() -> id()) -> get();
        // 日付条件データ抽出
        // $posts = Post::whereDate('created_at', '>=', '2026-01-01') -> get();
        // $posts = Post:: where('user_id', 2) -> whereDate('created_at', '>=', '2026-01-01') -> get();
        // orderByを使用
        $posts = Post::orderBy('created_at', 'desc') -> get();
        // dd($posts);
        // $posts = DB::table('posts') -> get();
        return view('posts.index', compact('posts'));
    }

    // 登録画面表示
    public function create() {
        return view('posts.create');
    }

    //新規登録処理
    public function store(Request $request) {
        Gate::authorize('test');
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

    // 投稿の個別表示
    // 依存注入
    // public function show(Post $post) {
    public function show($id) {
        // 依存注入
        // return view('post.show', compact('post'));

        $post = Post::find($id);
        return view('posts.show', compact('post'));
    }

    //編集画面表示
    public function edit(Post $post) {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post) {
        $validated = $request->validate([
            'title' => 'required | max:20',
            'body' => 'required | max:400',
        ]);

        $validated['user_id'] = auth()->id();

        $post->update($validated);

        $request->session()->flash('message', '更新しました。');
        return back();
    }

    // 削除機能
    public function destroy(Request $request, Post $post) {
        $post->delete();
        $request->session()->flash('message', '削除しました。');
        // return redirect()->route('post.index');
        return redirect('posts');
    }
}
