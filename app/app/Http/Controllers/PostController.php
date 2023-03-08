<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // バリデーション
        $inputs = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'publication' => 'required|max:255',
            'price' => 'required|max:255',
            'image' => 'image|max:1024',
        ]);

        // postclassのインスタンス作成
        $post = new Post();
        $post->title = $inputs['title'];  // $inputsでバリデーションを通った値を表示
        $post->author = $inputs['author'];    // $inputsでバリデーションを通った値を表示
        $post->publication = $inputs['publication'];    // $inputsでバリデーションを通った値を表示
        $post->price = $inputs['price'];    // $inputsでバリデーションを通った値を表示
        $post->user_id = auth()->user()->id; // ログインしているユーザ

        if(request('image'))
        {
            // 画像ファイルの元々の名前を取ってきて$originalに代入
            // ファイル送信時に元々のファイル名が無くなるため
            $original = request()->file('image')->getClientOriginalName();
            // 保存したファイルには、日時入りのファイル名ができる
            $name = date('Ymd_His').'_'.$original;
            // 送られてきた画像ファイルをstorage/imageへ移動させ $nameという名前をつけ保存
            $file = request()->file('image')->move('storage/images', $name);
            // 画像ファイルの名前を別途DBへ保存
            $post->image = $name;
        }

        $post->save();
        return back()->with('message', '投稿を保存しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // バリデーション
        $inputs = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'publication' => 'required|max:255',
            'price' => 'required|max:255',
            'image' => 'image|max:1024',
        ]);

        // postclassのインスタンス作成
        $post = new Post();
        $post->title = $inputs['title'];  // $inputsでバリデーションを通った値を表示
        $post->author = $inputs['author'];    // $inputsでバリデーションを通った値を表示
        $post->publication = $inputs['publication'];    // $inputsでバリデーションを通った値を表示
        $post->price = $inputs['price'];    // $inputsでバリデーションを通った値を表示
        $post->user_id = auth()->user()->id; // ログインしているユーザ

        if(request('image'))
        {
            // 画像ファイルの元々の名前を取ってきて$originalに代入
            // ファイル送信時に元々のファイル名が無くなるため
            $original = request()->file('image')->getClientOriginalName();
            // 保存したファイルには、日時入りのファイル名ができる
            $name = date('Ymd_His').'_'.$original;
            // 送られてきた画像ファイルをstorage/imageへ移動させ $nameという名前をつけ保存
            $file = request()->file('image')->move('storage/images', $name);
            // 画像ファイルの名前を別途DBへ保存
            $post->image = $name;
        }

        $post->save();
        return back()->with('message', '投稿を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('home')->with('message', '投稿を削除しました');
    }
}
