@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-10 mt-6">
            <div class="card-body">
                <h1 class="mt4">書籍追加</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                            @if (empty($errors->first('image')))
                                <li>画像ファイルがあれば再度選択してください。</li>
                            @endif
                        </ul>
                    </div>
                @endif

                <!-- controller(store)で設定したメッセージを表示 -->
                @if (session('message'))
                    <div class="alert alert-success">{{session('message')}}</div>
                @endif

                <form method="post" action="{{route('post.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">書籍名</label>
                        <!-- value部分記載することで、バリデーションエラーが起きた際に入力した文字が保持される -->
                        <input type="text" name="title" class="form-control" id="title" value="{{old('title')}}" placeholder="書籍名を入力してください">
                    </div>

                    <div class="form-group">
                        <label for="author">著者名</label>
                        <!-- value部分記載することで、バリデーションエラーが起きた際に入力した文字が保持される -->
                        <input type="text" name="author" class="form-control" id="author" value="{{old('author')}}" placeholder="著者名を入力してください">
                    </div>

                    <div class="form-group">
                        <label for="publication">出版社</label>
                        <!-- value部分記載することで、バリデーションエラーが起きた際に入力した文字が保持される -->
                        <input type="text" name="publication" class="form-control" id="title" value="{{old('publication')}}" placeholder="出版社を入力してください">
                    </div>

                    <div class="form-group">
                        <label for="url">URL</label>
                        <!-- value部分記載することで、バリデーションエラーが起きた際に入力した文字が保持される -->
                        <input type="text" name="url" class="form-control" id="url" value="{{old('url')}}" placeholder="URLを入力してください">
                    </div>

                    <div class="form-group">
                        <label for="image">画像</label>
                        <div class="col-md-6">
                            <input id="image" type="file" name="image">
                        </div>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-success">送信する</button>
                </form>
            </div>
        </div>
    </div>
@endsection
