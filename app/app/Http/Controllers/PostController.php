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
        // ユーザー一覧をページネートで取得
        $users = User::paginate(20);

        // 検索フォームで入力された値を取得する
        $search = $request->input('serarch');

        // クエリビルダ
        $query = User::query();

        // もし検索フォームにキーワードが入力されたなら
        if ($search) {
            // 全角スペースを半角に変換
            $spaceConversion = mb_convert_kana($search, 's');

            // 単語を半角スペースで区切り、配列にする
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
            foreach ($wordArraySearched as $value) {
                $query->where('name', 'like', '%', $value.'%');
            }

            // 上記で取得した$queryをページネートにし、変数$usersに代入
            $users = $query->paginate(20);
        }

        // ビューにusersとsearchを変数として渡す
        return view('Post.index')
            ->with([
                'users' => $users,
                'search' => $search,
            ]);
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
            'url' => 'required',
            'image' => 'image|max:1024',
        ]);

        // postclassのインスタンス作成
        $post = new Post();
        $post->title = $inputs['title'];  // $inputsでバリデーションを通った値を表示
        $post->author = $inputs['author'];    // $inputsでバリデーションを通った値を表示
        $post->publication = $inputs['publication'];    // $inputsでバリデーションを通った値を表示
        $post->url = $inputs['url'];    // $inputsでバリデーションを通った値を表示
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
            'url' => 'required',
            'image' => 'image|max:1024',
        ]);

        // postclassのインスタンス作成
        $post = new Post();
        $post->title = $inputs['title'];  // $inputsでバリデーションを通った値を表示
        $post->author = $inputs['author'];    // $inputsでバリデーションを通った値を表示
        $post->publication = $inputs['publication'];    // $inputsでバリデーションを通った値を表示
        $post->url = $inputs['url'];    // $inputsでバリデーションを通った値を表示
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
