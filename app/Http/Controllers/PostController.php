<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = Post::all();
        // ページネーション付きで一覧表示
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'title' => 'required | max: 20',
            'body' => 'required | max: 400',
        ]);

        $validated['user_id'] = auth()->id();

        $post = Post::create($validated);

        // flash()を使った場合
        // $request->session()->flash('message', '正常に投稿が完了しました。');
        // return redirect()->route('post.index');

        // with()を使った場合

        return redirect()->route('post.index')->with([
            'message' => '投稿が正常に完了しました。',
            'type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Post $post)
    {
        if(auth()->id() !== $post->user_id) {
            // $request->session()->flash('message', 'この投稿は投稿者本人以外は編集できません。');
            // return redirect()->route('post.index');

            // with()を使った場合
            return redirect()->route('post.index')->with([
                'message' => 'この投稿は投稿者本人以外は編集できません。',
                'type' => 'danger',
            ]);
        }
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if(auth()->id() !== $post->user_id) {
                // $request->session()->flash('message', 'この投稿は投稿者本人以外は編集できません。');
                // return redirect()->route('post.index');

                // with()を使った場合
                return redirect()->route('post.index')->with([
                    'message' => 'この投稿は投稿者本人以外は編集できません。',
                    'type' => 'danger',
                ]);
        }

        $validated = $request->validate([
            'title' => 'required | max: 20',
            'body' => 'required | max: 400',
        ]);

        $validated['user_id'] = auth()->id();

        $post->update($validated);

        // $request->session()->flash('message', '更新しました。');
        // return redirect()->route('post.show', compact('post'));

        return redirect()->route('post.show', compact('post'))->with([
            'message' => '更新しました。',
            'type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {

        if(auth()->id() !== $post->user_id) {
                // $request->session()->flash('message', 'この投稿は投稿者本人以外は編集できません。');
                // return redirect()->route('post.index');

                // with()を使った場合
                return redirect()->route('post.index')->with([
                    'message' => 'この投稿は投稿者本人以外は削除できません。',
                    'type' => 'danger',
                ]);
        }

        $post->delete();
        // $request->session()->flash('message', '削除しました。');
        // return redirect()->route('post.index');

        // with()を使った場合
        return redirect()->route('post.index')->with([
            'message' => '削除しました。',
            'type' => 'danger',
        ]);
    }
}
