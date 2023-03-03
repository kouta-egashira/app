<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $posts変数にPostTableの中身を全て取ってきて代入
        $posts = Post::orderBy('id', 'desc')->get(); // 投稿を新しい順で表示(desc)
        // ログインしているユーザーを$user変数に代入
        $user = auth()->user();
        // home画面を表示。また、compactでview画面に変数を受け渡す。
        return view('home', compact('posts', 'user'));
    }
}
